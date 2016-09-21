<?php
defined('BASEPATH') OR die();
//define('BASEPATH',dirname(__FILE__).'/../');

/**
*  * Desc: php操作mysql的封装类
*  * Authoar gnp 
*  * Date: 2015/10/23
*  * 连接模式：Mysqli
*  */

class MysqliDB{
    private $Prefix = '';
    private $Port;
    private $Conn;

    private static $_instance;


    private function __construct(){
        $config = require BASEPATH.'/config/config.php';
        foreach($config['mysql'] as $key=>$v){
            $$key = $v;
        }
        $this->Prefix = $prefix;
        $Conn = new mysqli($host,$username, $password, $database);

        /* check connection */
        if (mysqli_connect_errno()) {
            printf("Connect failed: %s\n", mysqli_connect_error());
            exit();
        }
        $Conn->set_charset("utf8");
        $this->Conn = $Conn;
    }

    public static function getInstance(){
        if(!(self::$_instance instanceof self)){
            self::$_instance = new self();
        } 
        return self::$_instance;
    }

    private function __clone(){}

    public function __destruct(){
        $this->Conn->close();
    }

    /**数据库插入方法
     *
     */
    public function insertDb($sql){
        $this->Conn->query($sql);
        return $this->Conn->affected_rows;
    }

    /**数据库查询方法
     *
     */
    public function query($sql){
        $res = $this->Conn->query($sql);
        return $res->fetch_array(MYSQLI_ASSOC);
    }

    /**mysql安全过滤方法
     * string $str
     */
    private function escape($str){
        return $this->Conn->real_escape_string($str);
    }
}

$test = MysqliDB::getInstance();


