<?php
/*
 * @todo 服务访问者
 */
interface ServerVisitor{
    public function sendMessage(SendMsg $message);
    public function pushMessage(PushMsg $message);
}
class AliYun implements ServerVisitor{
    public function sendMessage(SendMsg $message)
    {
        // TODO: Implement sendMessage() method.
        echo '阿里云短信发送'.PHP_EOL;
    }
    public function pushMessage(PushMsg $message)
    {
        // TODO: Implement pushMessage() method.
        echo '阿里云短信推送'.PHP_EOL;
    }
}
class BaiDuYun implements ServerVisitor{
    public function sendMessage(SendMsg $message)
    {
        // TODO: Implement sendMessage() method.
        echo '百度云短信发送'.PHP_EOL;
    }
    public function pushMessage(PushMsg $message)
    {
        // TODO: Implement pushMessage() method.
        echo '百度云短信推送'.PHP_EOL;
    }
}
/*
 * @todo 信息推送
 */
interface Msg{
    public function Msgs(ServerVisitor $serverVisitor);
}
class PushMsg implements Msg{
    public function Msgs(ServerVisitor $serverVisitor)
    {
        // TODO: Implement Msg() method.
        echo PHP_EOL.'开始推送'.PHP_EOL;
        $serverVisitor->pushMessage($this);
    }
}
class SendMsg implements Msg{
    public function Msgs(ServerVisitor $serverVisitor)
    {
        // TODO: Implement Msg() method.
        echo '准备发送Msg'.PHP_EOL;
        $serverVisitor->sendMessage($this);
    }
}
/*
 * @todo 客户端请求
 */
class ObjectStruct {
    protected $elements =[];
    //进入
    public function Attach(Msg $ele){
        $this->elements[] = $ele;
    }
    //退出会话
    public function Detach(Msg $ele){
        $position = 0;
        foreach ($this->elements as $e){
            if ($e == $ele){
                unset($this->elements[$position]);
                break;
            }
            $position++;
        }
    }
    //接收发送
    public function Accept(ServerVisitor $serverVisitor){
        foreach ($this->elements as $e){
            $e->Msgs($serverVisitor);
        }
    }
}

$o = new ObjectStruct();
$o->Attach(new PushMsg());
$o->Attach(new SendMsg());

$v1 = new AliYun();
$v2 = new BaiDuYun();

$o->Accept($v1);

sleep(2);
$o->Accept($v2);
