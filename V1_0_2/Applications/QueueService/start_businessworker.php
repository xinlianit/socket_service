<?php 
/**
 * This file is part of workerman.
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the MIT-LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @author walkor<walkor@workerman.net>
 * @copyright walkor<walkor@workerman.net>
 * @link http://www.workerman.net/
 * @license http://www.opensource.org/licenses/mit-license.php MIT License
 */
use \Workerman\Worker;
use \GatewayWorker\BusinessWorker;
use \Workerman\Autoloader;

// 自动加载类
require_once __DIR__ . '/../../Workerman/Autoloader.php';
Autoloader::setRootPath(__DIR__);

$config = include_once __DIR__ . '/../../../Config/config.php';


// bussinessWorker 进程
$worker = new BusinessWorker();
// worker名称
$worker->name = $config['LOGIC_SERVICE_NAME'] ? $config['LOGIC_SERVICE_NAME'] : 'BusinessWorker';
// bussinessWorker进程数量
$worker->count = $config['LOGIC_PROCESS_COUNT'] ? $config['LOGIC_PROCESS_COUNT'] : 1;
// 服务注册地址
$worker->registerAddress = $config['REGISTER_NODE_ADDRESS'] ? $config['REGISTER_NODE_ADDRESS'] : '127.0.0.1:1234';

// 如果不是在根目录启动，则运行runAll方法
if(!defined('GLOBAL_START')) {
    Worker::runAll();
}

