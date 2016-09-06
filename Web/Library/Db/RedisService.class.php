<?php
/**
 * Redis操作类
 */
namespace Db;

class RedisService {
    /**
     * redis连接
     * @var unknown
     */
    private $connect;
    
    /**
     * redis对象
     * @var unknown
     */
    private static $redisInstance;
    
    /**
     * redis配置
     * @var unknown
     */
    private $config;
    
    public function __construct($host=null , $port=null , $auth=null){
        global $config;
        $this->config = $config['REDIS'];
        
        $host = $host ? $host : $this->config['HOST'];
        $port = $port ? $port : $this->config['PORT'];
        $auth = $auth ? $auth : $this->config['AUTH'];
        
        self::$redisInstance = new \Redis();
        $this->connect = self::$redisInstance->connect( $host , $port );
        if( isset($auth) ) self::$redisInstance->auth( $auth );
    }
    
    /**
     * 获取数据
     * @param string $key               键名
     * @return array|string|boolean
     */
    public function find($key){
        $data = self::$redisInstance->get( $this->config['PREFIX'] . $key );
        
        if( !$data )
            return false;
        
        $result = json_decode( $data , true );
        
        if( !is_array($result) )
            $result =  $data;
        
        return $result;
    }
    
    public function select(){
        
    }
    
    /**
     * 添加单个数据
     * @param array $value         数据值
     * @param string $key          数据键名          
     * @param int $expire          过期时间；0：不限制，大于0过期时间（单位：秒）
     * @return NULL|boolean|string
     */
    public function add($value=null , $key = null , $expire = 0){
        $key = isset($key) ? $key : md5(time().mt_rand(10000,99999).mt_rand(100000,999999));
        
        if( !isset($value) )
            return null;
        
        $result = self::$redisInstance->set( $this->config['PREFIX'] . $key , json_encode($value) );
        
        if( !$result )
            return false;
        
        if( $expire > 0 )
            self::$redisInstance->expire( $this->config['PREFIX'] . $key , $expire);
        
        return $key;
    }
    
    public function edit(){
        
    }
    
    public function delete(){
        
    }
}
