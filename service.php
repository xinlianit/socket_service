<?php 
//获取tcp协议号码。
$tcp = getprotobyname("tcp");  
// 建立server端socket ，创建并返回一个套接字，也称作一个通讯节点。一个典型的网络连接由 2 个套接字构成，一个运行在客户端，另一个运行在服务器端。
$socket = socket_create(AF_INET, SOCK_STREAM, $tcp); 
//绑定要监听的ip和端口，这里绑定的ip一定要写局域网ip，写成127.0.0.1客户端将无法与服务端建议连接。
socket_bind($socket, '192.168.3.89', 10008);    
 //监听端口    
socket_listen($socket);     
  
//初始化一个数据，和客户端通信 
$buffer = "欢迎连接..."; 
while (true) { 
    // 接受客户端请求过来的一个socket连接 
    $connection = socket_accept($socket); 
    if(!$connection){ 
        echo "connect faild"; 
    }else{ 
            echo "客户已连接\n"; 
            // 向客户端传递一个信息数据 
            if ($buffer != "") { 
                socket_write($connection, $buffer . "\n"); 
            } else { 
                echo "没有数据可发送\n" ; 
            } 
            // 从客户端获取得的数据
            while ($data = @socket_read($connection, 1024, PHP_NORMAL_READ)) { 
                    printf("Buffer: " . $data . "\n"); 
                    //取得信息给客户端一个反馈, Thank you client, you data is  Received success发给客户端的回应信息。
                    @socket_write($connection, "获取数据成功！\n"); 
            } 
    } 
 
    //关闭 socket
    socket_close( $connection ); 
    //printf("关闭Socket!\n"); 
} 
?>