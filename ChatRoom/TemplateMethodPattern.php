<?php
abstract class Cache {
    protected $config;
    protected $conn;
    public function __construct(){
        $this->init();
    }
    //获取配置项
    abstract public function getConfig();
    //打开此链接
    abstract public function openConnection();
    //检查是否链接
    abstract public function checkConnection();
    //初始进程
    public function init(){
        $this->getConfig();
        $this->openConnection();
        $this->checkConnection();
    }
}
//Mysql服务
class Mysql extends Cache {
    public function getConfig()
    {
        // TODO: Implement getConfig() method.
        echo '当前获取Mysql服务!'.PHP_EOL;
        $this->config = 'Mysql';
    }
    public function openConnection()
    {
        // TODO: Implement openConnection() method.
        echo '链接Mysql!'.PHP_EOL;
        $this->conn = 1;
    }
    public function checkConnection()
    {
        // TODO: Implement checkConnection() method.
        if ($this->conn == 1){
            echo 'Mysql连接成功!' ,PHP_EOL;
        }else{
            echo 'Mysql连接失败,请检查配置项!'.PHP_EOL;
        }

    }
}

//redis服务
class Redis extends Cache{
    public function getConfig()
    {
        // TODO: Implement getConfig() method.
        echo '当前获取Redis服务!'.PHP_EOL;
        $this->config = 'Redis';
    }
    public function openConnection()
    {
        // TODO: Implement openConnection() method.
        echo '链接Redis!'.PHP_EOL;
        $this->conn = 1;
    }
    public function checkConnection()
    {
        // TODO: Implement checkConnection() method.
        if ($this->conn == 1){
            echo 'Redis连接成功!' ,PHP_EOL;
        }else{
            echo 'Redis连接失败,请检查配置项!'.PHP_EOL;
        }
    }
}
$m = new Mysql();

sleep(1);
$r = new Redis();
