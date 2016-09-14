<?php
header("Content-type: text/html; charset=utf-8");
define('ROOT_PATH', str_replace('/Web/Controller', '', __DIR__ ));
use \Lib\Curl;
use \Lib\RedisService;
//引入客户端
require_once ROOT_PATH . '/Lib/Curl.class.php';
require_once ROOT_PATH . '/Lib/RedisService.class.php';

//载入配置文件
$config = include_once ROOT_PATH . '/Config/config.php';

//数据请求服务器
@$action = $_GET['action'];

switch( $action ){
	//排队列表
	case 'list':
	    $data = file_get_contents("php://input");
	    if( !empty($data) ) $post = json_decode($data , true);
	    
		if( strtoupper($_SERVER['REQUEST_METHOD']) == 'POST' ){
			//模拟提交
			$post_data = array(
				'token'			=> $post['token'] ? $post['token'] : '',
				'dkId'			=> @$post['dkId'] ? $post['dkId'] : ''
			);
			
			$login_rs = Curl::getIns($config['API_HOST'] . '/Queue/lists')->post( $post_data );
			
			echo($login_rs);die;
		}
		break;
	//叫号
	case 'callNumber':
		$data = file_get_contents("php://input");
	    if( !empty($data) ) $post = json_decode($data , true);
	    
	    $queue_info = Curl::getIns($config['API_HOST'] . '/Teevee/overview')->post( $post );
	    $queue_info = json_decode($queue_info,true);
	    
	    foreach($queue_info['dkList'] as $k=>$v){
	        if($v['dkId'] == $post['dkId']){
	            $queue_info['dkList'][$k]['nowCallNum'] = $post['callNum'];
	        }
	    }
	    $queue_info['action']  = 'callnumber';
	    $queue_info['type']    = 'queue';
	    $queue_info['shopid'] = 1;
	    $data = json_encode($queue_info);
	    //通知websocket
	    $client = stream_socket_client('tcp://' . $config['PUSH_NODE_ADDRESS_PORT']);
	    fwrite($client, $data . "\n");
	    fclose($client);
	    //缓存redis
	    
	    
	    echo($data);die;
		break;
	default:
		exit('Access Deny!');
		break;
}
?>