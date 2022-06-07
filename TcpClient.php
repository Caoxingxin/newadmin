<?php
class TcpClient{
    //服务器端口
    private $server_port;
    //服务器地址
    private $server_address;
    //socket处理
    private $socket_handle;

    public function __construct($port=8080,$address="127.0.0.1"){
        $this->server_port = $port;
        $this->server_address = $address;
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

    public function connectToServer(){
        $data = '';
        $this->addSocket();
        //第二步连接服务器
        if (!socket_connect($this->socket_handle,$this->server_address,$this->server_port)){
            echo socket_strerror(socket_last_error($this->socket_handle)). "\n";
            exit(1);
        }else{
            while(true){
//                $data = fgetc(STDIN);
                $data = readline( 'Prompt: ' );
                var_dump($data);
                if (strncmp($data,"quit",4) == 0){
                    break;
                }
                socket_write($this->socket_handle,$data);
            }
        }
    }

}
$client = new TcpClient();
$client->connectToServer();
?>
