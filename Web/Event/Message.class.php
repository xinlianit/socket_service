<?php
/**
 * 信息处理类
 */
namespace Event;

class Message {
    /**
     * 广播信息
     * @param string $message       发送内容
     * @return boolean|array|null
     */
    public static function broadcast($message){
        global $worker;
        
        //没有任何客户端连接
        if( empty($worker->uidConnections) )
            return null;
        
        //所有发送状态
        $result_status = array();
        
        //所有连接池
        foreach( $worker->uidConnections as $connection ){
            $send_result = $connection->send( $message );
            
            array_push( $result_status , $send_result ? 1 : 0 );
        }
        
        return empty($result_status) ? false : $result_status;
    }
    
    /**
     * 通过客户端ID指定连接发送
     * @param string $client_id     客户端连接ID
     * @param string $message       发送消息
     * @return boolean
     */
    public static function sendMessageByClientId( $client_token , $message){
        global $worker;
        
        if( !isset($worker->uidConnections[$client_token]) )
            return false;
        
        return $worker->uidConnections[$client_token]->send( $message );
    }
}