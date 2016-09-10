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

/**
 * 用于检测业务代码死循环或者长时间阻塞等问题
 * 如果发现业务卡死，可以将下面declare打开（去掉//注释），并执行php start.php reload
 * 然后观察一段时间workerman.log看是否有process_timeout异常
 */
//declare(ticks=1);

use \GatewayWorker\Lib\Gateway;
use \Lib\Curl;

//根路径
define('ROOT_PATH', str_replace('/V1_0_2/Applications/QueueService', '', __DIR__ ));
//数据请求服务器
define('REQUEST_SERVICE' , 'http://api.msp.my');

require_once ROOT_PATH . '/Lib/Curl.class.php';
require_once ROOT_PATH . '/Lib/RedisService.class.php';

/**
 * 主逻辑
 * 主要是处理 onConnect onMessage onClose 三个方法
 * onConnect 和 onClose 如果不需要可以不用实现并删除
 */
class Events
{
    /**
     * redis资源
     * @var unknown
     */
    private static $redis;
    
    public function __construct(){
        self::$redis = new Lib\RedisService('192.168.3.100','6379','redis123');    
    }
    /**
     * 当客户端连接时触发
     * 如果业务不需此回调可以删除onConnect
     * 
     * @param int $client_id 连接id
     */
    public static function onConnect($client_id) {}
    
   /**
    * 当客户端发来消息时触发
    * @param int $client_id 连接id
    * @param mixed $message 具体消息
    */
   public static function onMessage($client_id, $message) {
       $data = json_decode( $message , true );
       
       
       switch($data['action']){
           //心跳包
           case 'pong':
               //输出日志
               echo date('Y-m-d H:i:s',time()) . "客户端心跳：" . $message."\n";
               break;
           //登录
           case 'login':
               //输出日志
               echo date('Y-m-d H:i:s',time()) . "登录用户：" . $message."\n";
               //验证登录有效性
               $login_info = Curl::getIns(REQUEST_SERVICE . '/Member/getLoginInfo')->post( array('token'=>$data['token']) );
               $login_info = json_decode($login_info , true);
               if( $login_info['statusCode'] != 1 ){
                   //输出日志
                   echo date('Y-m-d H:i:s',time()) . "登录失败：" . $message.";原因：".$login_info['statusMsg']."\n";
                   //通知客户端重新登录
                   Gateway::sendToClient($client_id, '{"statusCode":"-1","statusMsg":"登录信息过期"}');
                   //关闭客户端连接
                   Gateway::closeClient($client_id);
                   echo date('Y-m-d H:i:s',time()) . "关闭连接：" . $message."\n";
                   return ;
               }
               
               //绑定的UID
               Gateway::bindUid($client_id, $login_info['result']['shopid']);
               
               //获取排队数据
               $queue_data = Curl::getIns(REQUEST_SERVICE . '/Teevee/overview')->post( array('token'=>$data['token']) );
               //$queue_data = self::$redis->
               $data = json_decode($queue_data,true);
               $data['type'] = 'queue';
               
               //发送数据
               Gateway::sendToUid($login_info['result']['shopid'],json_encode($data));
               break;
       }
       
   }
   
   /**
    * 当用户断开连接时触发
    * @param int $client_id 连接id
    */
   public static function onClose($client_id) {
       echo date('Y-m-d H:i:s',time()) . "客户端断开连接：" . $client_id."\n";
   }
}
