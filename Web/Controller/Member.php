<?php
header("Content-type: text/html; charset=utf-8");

@$action = $_GET['action'];

$data = file_get_contents("php://input");
if( !empty($data) ) $post = json_decode($data , true);

switch( $action ){
	case 'login':
		if( strtoupper($_SERVER['REQUEST_METHOD']) == 'POST' ){
			//模拟提交
			$url = 'http://api.msp.my/Member/login';
			$post_data = array(
				'busineId'		=> $post ? $post['shopcode'] : '',
				'account'		=> $post ? $post['account'] : '',
				'passwd'		=> $post ? $post['passwd'] : '',
			);
			
			//初始化curl
			$cul = curl_init();
			//curl提交地址
			curl_setopt( $cul , CURLOPT_URL , $url );
			//设置返回值
			curl_setopt( $cul , CURLOPT_RETURNTRANSFER , 1 );
			//提交数据
			curl_setopt( $cul , CURLOPT_POST , 1 );
			curl_setopt( $cul , CURLOPT_POSTFIELDS , $post_data );
			
			//执行curl
			$output = curl_exec( $cul );
			//关闭curl
			curl_close( $cul );
			
			echo($output);die;
		}
		break;
	default:
		exit('Access Deny!');
		break;
}
?>