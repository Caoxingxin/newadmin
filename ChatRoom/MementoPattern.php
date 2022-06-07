<?php
/*
 * @todo 备忘录模式
 */
//短信源类
class Message {
    //内容
    public $content;
    //手机
    public $to;
    //备忘录状态（发送状态）
    private $state;
    public $time;
    public function __construct($to,$content)
    {
        $this->to = $to;
        $this->content = $content;
        //默认状态
        $this->state = '未发送';
        $this->time = time();
    }
    public function show(){
        echo $this->to, '---' , $this->content, '---', $this->time, '---', $this->state, PHP_EOL;
    }
    //创建备忘录
    public function CreateSaveState(){
        $s = new SaveState();
        $s->setState($this->state);
        return $s;
    }
    //还原状态
    public function setSaveState($s){
        if ($this->state != $s->getState){
            $this->time = time();
        }
        $this->state = $s->getState;
    }
    //设置状态
    public function setState($state){
        $this->state = $state;
    }
    //获取状态
    /**
     * @return string
     */
    public function getState(): string
    {
        return $this->state;
    }


}
//备忘录
class SaveState{
    private $state;
    /**
     * @param mixed $state
     */
    public function setState($state): void
    {
        $this->state = $state;
    }

    /**
     * @return mixed
     */
    public function getState()
    {
        return $this->state;
    }
}
//备忘录目录（状态目录）
class stateContainer{
    private $s;
    public function setSaveState($s){
        $this->s = $s;
    }
    public function getSaveState(){
        return $this->s;
    }
}
//模拟发送
$mList = [];
$scList = [];
//循环五条短信
for ($i=0;$i<5;$i++){
    $m = new Message('手机号456'.$i,'内容999'.$i);
    echo '初始状态:';
    $m->show();

    //保存初始信息至备忘录
    $sc = new stateContainer();
    $sc->setSaveState($m->CreateSaveState());
    $scList[] = $sc;

    //模拟发送, 2成功，3失败
    $pushState = mt_rand(2,3);
    $m->setState($pushState ==  2 ? '发送成功':'发送失败');
    echo '发布后状态:';
    $m->show();
    $mList[] = $m;
}

//模拟另一个线程查找发送失败的短信并把它们还原到未发送状态
sleep(2);
print_r($scList);
print_r($mList);
foreach($mList as $k=>$v){

    if ($v->getState() == '发送失败'){
        $v->setSaveState($scList[$k]->getSaveState());
    }
    echo '查询发布失败后状态：';
    $v->show();
}
