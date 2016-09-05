<?php 
/**
 * 全局配置
 */
return array(
    //socket协议服务
    'SOCKET_PROTOCOL_SERVER'     => 'websocket://0.0.0.0:1234',
    //text协议服务
    'TEXT_PROTOCOL_SERVER'       => 'text://0.0.0.0:5678',
    //启动进程数
    'PROCESS_COUNT'              => 1,
    //单个进程最大请求数
    'MAX_REQUEST'                => 10000,
    //实例名称
    'INSTANCE_NAME'              => 'msc_pai_socket_service',
    //控制台打印输出数据保存路径
    'CONSOLE_PRINT_SAVE'         => '/tmp/msc_pai_socket_service_print.log',
    //运行日志保存路径
    'RUNTIME_LOG_SAVE'           => '/tmp/msc_pai_socket_service_run.log',
    
    //redis配置
    'REDIS' => array(
        'HOST'      => '192.168.3.102',
        'PORT'      => '6379',
        'AUTH'      => 'redis123',
        'PREFIX'    => 'msc::socket::',
    ),
);