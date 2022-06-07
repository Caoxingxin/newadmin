<?php

class TcpServer{
    private $port = 8080;
    private $address = "127.0.0.1";
    private $socket_handle;
    private $backlog =10;
    private $websockets;
    private $current_message_length;

    private $is_shakehanded;
    private $mask_key;

    public function __construct($port = 8080, $address = "127.0.0.1",$backlog = 10){
        $this->port = $port;
        $this->address = $address;
        $this->backlog = $backlog;
    }

    public function addSocket(){
        //第一步创建socket
        $this->socket_handle = socket_create(AF_INET, SOCK_STREAM,SOL_TCP);
        if (!$this->socket_handle){
            //创建失败抛出异常，socket_last_error获取最后一次socket操作错误码，socket_strerror打印出对应错误码所对应的可读性描述
            throw new Exception(socket_strerror(socket_last_error($this->socket_handle)));
        }else{
            echo "创建socket success\n";
        }
    }
    public function bindAddress(){
        //第二部绑定地址和端口号
        if (!socket_bind($this->socket_handle,$this->address,$this->port)){
            throw new Exception(socket_strerror(socket_last_error($this->socket_handle)));
        }else{
            echo "bind 地址 success\n";
        }
    }
    public function listen(){
        //第三步监听外来连接
        if(!socket_listen($this->socket_handle,$this->backlog)){
            throw new Exception(socket_strerror(socket_last_error($this->socket_handle)));
        }else{
            echo "socket listen success\n";
        }
    }
    public function accept(){
        //第四步接收连接
        $client_socket_handle = socket_accept($this->socket_handle);
        //连接成功过后测试截取数据
        if (!$client_socket_handle){
            echo "socket accept error\n";
        }else{
            while (true) {
                $p = 0;
                $bytes_num = socket_recv($client_socket_handle,$buffer,2048,0);
                if (!$bytes_num){
                    echo "socket_recv failed\n";
                    exit(1);
                }
                else{
                    echo "content from client:". $buffer."\n";
                }
            }

        }
    }
    public function startServer(){
        try {

            $this->addSocket();
            $this->bindAddress();
            $this->listen();
            $this->accept();

        }catch (\Exception $exception){
            echo $exception->getMessage()."\n";
        }

    }
}

$server = new TcpServer();
$server->startServer();

?>
