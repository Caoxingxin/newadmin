<?php
interface Message{
    public function send($message);
}

class AliYunMessage implements Message {
    public function send($message)
    {
        // TODO: Implement send() method.
        echo '阿里云消息：'.$message .PHP_EOL;
    }
}

class BaiDuYunMessage implements Message {
    public function send($message)
    {
        // TODO: Implement send() method.
        echo '百度云消息：'.$message .PHP_EOL;
    }
}

class CaoXinMessage implements Message {
    public function send($message)
    {
        // TODO: Implement send() method.
        echo '曹鑫消息：'.$message .PHP_EOL;
    }
}

class MessageContent{
    private $message;
    private $msg;
    public function __construct(Message $message)
    {
        $this->message = $message;
    }
    public function sendMessage($msg){
        $this->message->send($msg);
    }
}

$bdMsg = new BaiDuYunMessage();
$msgContent = new MessageContent($bdMsg);
$msgContent->sendMessage('百度云好啊');

//sleep(1);
$aliMsg = new AliYunMessage();
$msgContent = new MessageContent($aliMsg);
$msgContent->sendMessage('阿里云好啊');

//sleep(1);
$caoMsg = new CaoXinMessage();
$msgContent = new MessageContent($caoMsg);
$msgContent->sendMessage('曹鑫好啊');
