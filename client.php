<?php 
// 建立客户端的socet连接 
$socket = socket_create(AF_INET, SOCK_STREAM, SOL_TCP); 

//连接服务器端socket 
$connection = socket_connect($socket, '192.168.3.89', 10008);  

//要发送到服务端的信息。
$send_data = $_SERVER['REMOTE_ADDR'] . " 已连接!";

//是否连接成功
$buffer = @socket_read($socket, 1024, PHP_NORMAL_READ);

if( $_GET['data'] ){
    socket_write( $socket, $_GET['data'] . "\n");
}


/*
//客户端去连接服务端并接受服务端返回的数据，如果返回的数据保护not connect就提示不能连接。
while ($buffer = @socket_read($socket, 1024, PHP_NORMAL_READ)) { 
    if (preg_match("/not connect/",$buffer)) { 
        echo "没有链接\n"; 
        break; 
    } else { 
        //服务端传来的信息 
        echo "服务器回复: " . $buffer . "\n"; 
        // 将客户的信息写到通道中，传给服务器端 
        if (!socket_write($socket, "$send_data\n")) { 
            echo $_SERVER['REMOTE_ADDR'] . "写入成功！\n"; 
        } 
        //服务器端收到信息后，客户端接收服务端传给客户端的回应信息。 
        while ($buffer = socket_read($socket, 1024, PHP_NORMAL_READ)) { 
                echo "发送到服务器：" . $send_data ."\n 来自服务器的响应：" . $buffer . "\n"; 
        }        
  
    } 
} 
*/
  
?>