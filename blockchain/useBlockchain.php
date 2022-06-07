<?php
include('blockchain.php');
class Blockchain{
    public $blocks = [];

    //默认区块头
    public function __construct(){
        $this->blocks[] = new block('','new world');
    }

    //向区块链添加新的区块
    public function addBlock($data){
        $prevBlock = $this->blocks[count($this->blocks) - 1];
        $this->blocks[] = new block($prevBlock->getBlockHash(),$data);
    }

}
?>
