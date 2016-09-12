<?php
/**
 * 推送服务
 */
use \Workerman\Worker;
use \GatewayWorker\Gateway;
use \Workerman\Autoloader;

//自动加载
require_once __DIR__ . '/../../Workerman/Autoloader.php';

$config = include_once __DIR__ . '/../../../Config/config.php';

// gateway 进程，这里使用Text协议
$gateway = new Gateway($config['QUEUE_PUSH_SERVER'] ? $config['QUEUE_PUSH_SERVER'] : "Text://0.0.0.0:2345");
// gateway名称，status方便查看
$gateway->name = $config['PUSH_SERVICE_NAME'] ? $config['PUSH_SERVICE_NAME'] : 'Queue_Push';
// gateway进程数
$gateway->count = $config['PUSH_PROCESS_COUNT'] ? $config['PUSH_PROCESS_COUNT'] : 1;
// 本机ip，分布式部署时使用内网ip
$gateway->lanIp = $config['PUSH_NODE_ADDRESS'] ? $config['PUSH_NODE_ADDRESS'] : '127.0.0.1';
// 内部通讯起始端口，假如$gateway->count=4，起始端口为4000
// 则一般会使用4000 4001 4002 4003 4个端口作为内部通讯端口 
$gateway->startPort = $config['PUSH_PORT_START'] ? $config['PUSH_PORT_START'] : 4000;
// 服务注册地址
$gateway->registerAddress = $config['REGISTER_NODE_ADDRESS'] ? $config['REGISTER_NODE_ADDRESS'] : '127.0.0.1:1234';

// 如果不是在根目录启动，则运行runAll方法
if(!defined('GLOBAL_START')) {
    Worker::runAll();
}