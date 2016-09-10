<?php
/**
 * Redis操作类
 */
namespace Lib;

class RedisService {
    /**
     * @desc 自身实例
     * @var instance
     */
    private static $Ins;
    
    /**
     * @desc redis连接资源
     * @var resource
     */
    private static $connect;
    
    public function __construct($host , $port , $auth=null){
        self::$connect = new \Redis();
        self::$connect->connect( $host , $port );
        if(isset($auth)) self::$connect->auth($auth);
    }
    
    public function __destruct(){
        //self::$connect->close();
    }
    
    public static function instance($host , $port , $auth=null){
        if(self::$Ins instanceof self){
            return self::$Ins;
        }else{
            return self::$Ins = new self($host , $port , $auth);
        }
    }
}
