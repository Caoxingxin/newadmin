<?php
/*
 * @todo 中介者模式聊天室实例
 */
abstract class Mediator{
    abstract public function Send($message,$user);
}
class ChatMediator extends Mediator{
    public $users = [];
    //加入
    public function Attach($user){
        if (!in_array($user,$this->users)){
            $this->users[] = $user;
        }
    }
    //退出
    public function Detach($user){
        $position = 0;
        foreach ($this->users as $u){
            if ($user == $u){
                unset($this->users[$position]);
            }
            $position++;
        }
    }
    public function Send($message,$user){
        foreach($this->users as $u){
            if ($u == $user){
                continue;
            }
            $u->Notify($message);
        }
    }
}
abstract class User{
    public $mediator;
    public $name;
    public function __construct($mediator,$name)
    {
        $this->mediator = $mediator;
        $this->name = $name;
    }
}
class ChatUser extends User{
    public function Send($message){
        $this->mediator->Send($message . '(' . $this->name . '发送)',$this);
    }
    public function Notify($message){
        echo $this->name . '收到消息' .$message,PHP_EOL;
    }
}

$m = new ChatMediator();

$u1 = new ChatUser($m,'用户a');
$u2 = new ChatUser($m,'用户b');
$u3 = new ChatUser($m,'用户c');

$m->Attach($u1);
$m->Attach($u2);
$m->Attach($u3);

$u1->Send('Hello,大家好！');  //用户a发送消息，用户b、c收到消息

$u2->Send('你好呀！');          //用户a、c收到消息

$m->Detach($u2);            //用户b退出聊天室

$u3->Send('欢迎进入!');         //用户1收到消息
