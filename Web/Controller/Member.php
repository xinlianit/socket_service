<?php
header("Content-type: text/html; charset=utf-8");
define('ROOT_PATH', str_replace('/Web/Controller', '', __DIR__ ));
use \Lib\Curl;
require_once ROOT_PATH . '/Lib/Curl.class.php';

//数据请求服务器
define('REQUEST_SERVICE' , 'http://api.msp.my');
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
			
			$login_rs = Curl::getIns(REQUEST_SERVICE.'/Member/login')->post( $post_data );
			
			echo($login_rs);die;
		}
		break;
	default:
		exit('Access Deny!');
		break;
}
?>