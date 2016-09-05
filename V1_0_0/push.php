<?php 
require_once 'Library/Db/RedisService.class.php';

//载入配置文件
$config = include_once 'Config/config.php';

// 建立socket连接到内部推送端口
@$client = stream_socket_client('tcp://192.168.3.102:5678', $errno, $errmsg, 1);

// 推送的数据，包含uid字段，表示是给这个uid推送
$data = array('clinet_token'=>'0079ejdeckld7e9e8de00we8d0ew', 'percent'=>@$_GET['data']);

// 发送数据，注意5678端口是Text协议的端口，Text协议需要在数据末尾加上换行符
$redis = new Db\RedisService();

$array = array(
    'clinet_token'       =>'0079ejdeckld7e9e8de00we8d0ew',
    'list'      => array(
        array('name'=>'大桌' ,'people'=>'1-2人' , 'nowNum'=>'A'.rand(1,100) , 'loadCount'=>rand(1,100)),
        array('name'=>'中桌' ,'people'=>'3-4人' , 'nowNum'=>'B'.rand(1,100) , 'loadCount'=>rand(1,100)),
        array('name'=>'小桌' ,'people'=>'5-6人' , 'nowNum'=>'C'.rand(1,100) , 'loadCount'=>rand(1,100))
    )
);

fwrite($client, json_encode($array)."\n");

// 读取推送结果
echo "发送结果：" . fread($client, 8192);

fclose( $client );

//添加Redis服务器
$id = $redis->add($array , 'queue::show::0079ejdeckld7e9e8de00we8d0ew');

if( !$id ) {
    //redis数据写入失败，记录日志
}

echo '<a href="?data=1">叫号1</a><br/>';
echo '<a href="?data=2">叫号2</a><br/>';
echo '<a href="?data=3">叫号3</a><br/>';
echo '<a href="?data=4">叫号4</a><br/>';

?>