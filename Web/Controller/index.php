<?php 
//根路径
define('ROOT_PATH', str_replace('/Web', '', __DIR__ ));
use \Lib\Curl;
use \Lib\RedisService;
//引入客户端
require_once '../GatewayClient/Gateway.php';
require_once ROOT_PATH . '/Lib/Curl.class.php';
require_once ROOT_PATH . '/Lib/RedisService.class.php';

//载入配置文件
$config = include_once ROOT_PATH . '/Config/config.php';

//注册地址
Gateway::$registerAddress = $config['REGISTER_NODE_ADDRESS'];

//当前排队列表
$require_param = array(
    'token'     => 'b63c9e8427c0cebcde4c9775cbedf157',
);
$queue_info = Curl::getIns( $config['API_HOST'] . '/Queue/lists' )->post( $require_param );

//发送数据
$data = array(
    'list'      => array(
        array('name'=>'大桌' ,'people'=>'1-2人' , 'nowNum'=>'A'.rand(1,100) , 'loadCount'=>rand(1,100)),
        array('name'=>'中桌' ,'people'=>'3-4人' , 'nowNum'=>'B'.rand(1,100) , 'loadCount'=>rand(1,100)),
        array('name'=>'小桌' ,'people'=>'5-6人' , 'nowNum'=>'C'.rand(1,100) , 'loadCount'=>rand(1,100))
    )
);

//操作
$result = Gateway::sendToAll( json_encode($data) );

//添加Redis服务器
$id = RedisService::instance()->set( $data , 'msc::socket::queue::shop::' . date('Ymd',time()) . '::1' );
echo $id;
?>