<?php 
//引入客户端
require_once 'GatewayClient/Gateway.php';
require_once 'Library/Db/RedisService.class.php';

//载入配置文件
$config = include_once 'Config/config.php';

//注册地址
Gateway::$registerAddress = '192.168.3.100:1234';

//发送数据
$redis = new Db\RedisService();

$array = array(
    'clinet_token'       =>'0079ejdeckld7e9e8de00we8d0ew',
    'list'      => array(
        array('name'=>'大桌' ,'people'=>'1-2人' , 'nowNum'=>'A'.rand(1,100) , 'loadCount'=>rand(1,100)),
        array('name'=>'中桌' ,'people'=>'3-4人' , 'nowNum'=>'B'.rand(1,100) , 'loadCount'=>rand(1,100)),
        array('name'=>'小桌' ,'people'=>'5-6人' , 'nowNum'=>'C'.rand(1,100) , 'loadCount'=>rand(1,100))
    )
);

//操作
$result = Gateway::sendToAll( json_encode($array) );

//添加Redis服务器
$id = $redis->add($array , 'queue::show::0079ejdeckld7e9e8de00we8d0ew');
echo $id;
?>