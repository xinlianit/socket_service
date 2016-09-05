<?php
use Workerman\Worker;
require_once 'Workerman/Autoloader.php';
require_once 'Event/Message.class.php';
require_once 'Library/Db/RedisService.class.php';

//载入配置文件
$config = include_once 'Config/config.php';

//连接Reids
$redis = new Db\RedisService();

//初始化一个workerr容器，监听1234端口
$worker = new Worker( $config['SOCKET_PROTOCOL_SERVER'] );

/*
 * 注意这里进程数必须设置为1，否则会报端口占用错误
 * (php 7可以设置进程数大于1，前提是$inner_text_worker->reusePort=true)
 */
$worker->count              = $config['PROCESS_COUNT'];

//实例名称
$worker->name               = $config['INSTANCE_NAME'];

//打印输出保存文件路径
$worker->stdoutFile         = $config['CONSOLE_PRINT_SAVE'];

//文件输出文件
$worker->logFile            = $config['RUNTIME_LOG_SAVE'];

//客户端连接池
$worker->uidConnections = array();

//监听启动事件
$worker->onWorkerStart = function( $worker ){
    global $config;
    
    //开启一个内部端口，方便内部系统推送数据，Text协议格式 文本+换行符
    $inner_text_worker = new Worker( $config['TEXT_PROTOCOL_SERVER'] );
    
    //监听消息
    $inner_text_worker->onMessage = function($connection, $buffer){
        // $data数组格式，里面有uid，表示向那个uid的页面推送数据
        $data = json_decode($buffer, true);
        
        $chient_token       = $data['clinet_token'];
        
        unset($data['clinet_token']);
        
        $send_data          = json_encode($data);
        
        // 通过workerman，向uid的页面推送数据
        $ret = Event\Message::sendMessageByClientId( $chient_token , $send_data );
        
        // 返回推送结果
        $connection->send($ret ? 1 : 0);
    };
    
    //执行监听
    $inner_text_worker->listen();
    
};

//监听消息事件
$worker->onMessage = function( $connection , $data ){
    //请求数累计
    static $request_count = 0;
    
    //业务逻辑处理
    global $worker,$config,$redis;
    
    //客户端是否认证
    if( !isset($connection->uid) ){
        //设置验证
        $connection->uid = $data;
        
        //当前连接，保存到连接池
        $worker->uidConnections[$connection->uid] = $connection;
        
        //获取当前排队数据
        $data = $redis->find( 'queue::show::' . $connection->uid );
        
        //过滤客户token
        unset($data['clinet_token']);
    
        if( !$data )
            //获取默认数据
            $data = $redis->find( 'queue::default::' . $connection->uid );
        
        if( !$data ){
            //Curl远程请求，获取排队列表
        }
            
        //发送给客户端
        Event\Message::sendMessageByClientId( $connection->uid , json_encode($data) );
    }
    
    //判断是大于进程请求数
    if(++$request_count >= $config['MAX_REQUEST']){
        //退出当前进程，主进程会立刻重新启动一个全新进程补充上来,从而完成进程重启
        Worker::stopAll();
    }
};

//监听连接断开事件
$worker->onClose = function( $connection ){
    global $worker;
    
    //移除连接池中断开的连接
    if( isset($connection->uid) )
        unset( $worker->uidConnections[$connection->uid] );
};

//监听发送错误事件
$worker->onError = function( $connection , $code , $msg ){};

//监听重启
$worker->onWorkerReload = function( $worker ){};

//监听停止
$worker->onWorkerStop = function( $worker ){};

//监听连接
$worker->onConnect = function( $connection ){
    //设置当前连接发送缓冲区的大小(单位：字节b)；2MB
    $connection->maxSendBufferSize = 1024*1024*2;
};

//缓冲区数据已满
$worker->onBufferFull = function( $connection ){};

//缓冲区数据发送完毕
$worker->onBufferDrain = function( $connection ){};

//运行所有Worker实例
$worker::runAll();


