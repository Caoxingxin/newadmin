<?php
//抽象观察者
interface Observer{
    public function update($obj);
}
class Message implements Observer{
    function update($obj){
        echo '发送新订单信息:'. $obj->mobile . ' 通知给商家！';
    }
}
class Goods implements Observer{
    function update($obj)
    {
        // TODO: Implement update() method.
        echo '修改商品' . $obj->goodsId . '的库存！';
    }
}
class order{
    private $observers = [];
    //加入观察者
    public function attach($obj){
        $this->observers[] = $obj;
    }
    //退出观察者
    public function detach($obj){
        $position = 0;
        foreach($this->observers as $ob){
            if ($ob == $obj){
                array_splice($this->observers,$position,1);
            }
            ++$position;
        }
    }
    //通知观察者
    public function notify($obj){
        foreach ($this->observers as $ob){
            $ob->update($obj);
        }
    }
    //卖掉商品
    public function sale($mobile,$goodsID){
        $obj = new \stdClass();
        $obj->mobile = $mobile;
        $obj->goodsId = $goodsID;
        $this->notify($obj);
    }
}

$message = new Message();
$goods = new Goods();
$order = new Order();
$order->attach($message);
$order->attach($goods);
//调用卖出订单
$order->sale('4464640','order1111');

sleep(1);
$order->sale('18290469458','order99999');
