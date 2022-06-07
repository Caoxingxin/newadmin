<?php
class block{
    //前一个区块的hash值
    public $prevHash;
    //当前区块的hash值
    public $hash;
    //区块生成的时间戳
    public $timestamp;
    //区块保存的数据
    public $data;

    public function __construct($prevHash,$data){
        $this->prevHash = $prevHash;
        $this->data = $data;
        $this->timestamp = time();
        $this->setBlockHash();
    }
    //设置区块hash值
    public function setBlockHash(){
        $data = serialize($this);
        //区块hash值用SHA-256算法计算
        //prevHash,hash,timestamp 在区块链中称为区块头
        //使用serialize对整个区块进行序列化，然后用hash函数计算区块的hash值
        $this->hash = hash('sha256',$data);
    }
    //获取区块hash值
    public function getBlockHash(){
        return $this->hash;
    }
}
?>
