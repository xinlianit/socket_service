<?php 
/**
 * 全局配置
 */
return array(
    ####################### 服务器名称  #######################
    //注册服务名称
    'REGISTER_SERVICE_NAME'     => 'Register_Service',
    //推送服务名称
    'PUSH_SERVICE_NAME'         => 'Queue_Push',
    //websocket服务名称
    'IO_SERVICE_NAME'           => 'Queue_IO',
    //业务逻辑处理服务
    'LOGIC_SERVICE_NAME'        => 'Queue_Loigc',
    
    ###################### 服务监听地址 #####################
    //注册地址服务器
    'REGISTER_SERVER'           => 'Text://0.0.0.0:1234',       
    //text协议服务(对内)
    'QUEUE_PUSH_SERVER'         => 'Text://0.0.0.0:2345',
    //socket协议服务(对外)
    'QUEUE_IO_SERVER'           => 'Websocket://0.0.0.0:3456',
    
    ###################### 分布式部署服务地址 ##################
    //注册服务地址
    'REGISTER_NODE_ADDRESS'     => '192.168.3.100:1234',
    //socket服务节点地址
    'IO_NODE_ADDRESS'           => '192.168.3.100',
    //push服务节点地址
    'PUSH_NODE_ADDRESS'         => '192.168.3.100',
    //push服务地址
    'PUSH_NODE_ADDRESS_PORT'    => '192.168.3.100:2345',
    
    ##################### 服务进程数 ########################
    //注册服务进程数
    'REGISTER_PROCESS_COUNT'              => 1,
    //推送服务进程数
    'PUSH_PROCESS_COUNT'                  => 4,
    //webSocket服务进程数
    'IO_PROCESS_COUNT'                    => 4,
    //逻辑处理进程数
    'LOGIC_PROCESS_COUNT'                 => 4,
    
    ##################### 服务进程起始端口 ########################
    //websocket服务进程起始端口
    'IO_PORT_START'                       => 2000,
    //push服务进程起始端口
    'PUSH_PORT_START'                     => 3000,
    
    #################### 单进程请求数 #########################
    //注册进程最大请求数
    'REGISTER_MAX_REQUEST'                => 10000,
    //Push请求最大数
    'PUSH_MAX_REQUEST'                    => 10000,
    //webSocket请求最大数
    'WEBSOCKET_MAX_REQUEST'               => 10000,
    
    #################### 日志 #############################
    //控制台打印输出数据保存路径
    'CONSOLE_PRINT_SAVE'         => '/tmp/msc_pai_socket_service_print.log',
    //运行日志保存路径
    'RUNTIME_LOG_SAVE'           => '/tmp/msc_pai_socket_service_run.log',
    
    //是否开启心跳监测
    'HEART_OPEN'                 => false,
    //心跳间隔（单位：秒s）
    'HEART_INTERVAL'             => 10,
    
    //数据接口服务器
    'API_HOST'                   => 'http://api.msp.my',
    
    //redis配置
    'REDIS' => array(
        'HOST'      => '192.168.3.100',
        'PORT'      => '6379',
        'AUTH'      => 'redis123',
        'PREFIX'    => 'msc::socket::queue::shop::',
    ),
);