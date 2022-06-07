<?php
/*
 * @todo 状态模式不同会员案例
 */
class Member {
    //状态
    private $state;
    //会员积分
    private $score;
    //设置状态
    public function SetState($state) {
        $this->state = $state;
    }
    //设置积分
    /**
     * @param mixed $score
     */
    public function setScore($score): void
    {
        $this->score = $score;
    }
    //获取积分
    /**
     * @return mixed
     */
    public function getScore()
    {
        return $this->score;
    }
    //折扣
    public function disCount(){
        //print_r($this);
        return $this->state->discount($this);
    }
}
//抽象状态类
interface State{
    public function discount($member);
}

//白金会员
class PlatinumMemberState implements State{
    public function discount($member)
    {
        // TODO: Implement discount() method.
        if ($member->getScore() >= 1000){
            return 0.5;
        }else{
            //积分不够向下取
            $member->SetState(new GoldMemberState());
            return $member->discount();
        }
    }
}
//黄金会员
class GoldMemberState implements State{
    public function discount($member)
    {
        // TODO: Implement discount() method.
        if ($member->getScore() >= 800){
            return 0.8;
        }else{
            $member->SetState(new BronzeMemberState());
            return $member->discount();
        }
    }
}
//青铜会员
class BronzeMemberState implements State{
    public function discount($member)
    {
        // TODO: Implement discount() method.

        if($member->getScore() >= 500){
            return 0.9;
        }else{
            $member->SetState(new PlainMemberState());
            return $member->discount();
        }
    }
}
//普通会员
class PlainMemberState implements State{
    public function discount($member)
    {
        // TODO: Implement discount() method.
        return 0.95;
    }
}
$m = new Member();
$m->SetState(new PlatinumMemberState());

$m->setScore(1200);
echo '当前会员'. $m->getScore() .'积分，折扣为: ' . $m->disCount() ,PHP_EOL;


$m->setScore(500);
echo '当前会员'. $m->getScore() .'积分，折扣为: ' . $m->disCount() ,PHP_EOL;

sleep(1);
$m->setScore(600);
echo '当前会员'. $m->getScore() .'积分，折扣为: ' . $m->disCount() ,PHP_EOL;

sleep(1);
$m->setScore(12);
echo '当前会员'. $m->getScore() .'积分，折扣为: ' . $m->disCount() ,PHP_EOL;
