<?php
include('useBlockchain.php');
$bc = new Blockchain();
$bc->addBlock('this is block1');
$bc->addBlock('this is block2');

foreach ($bc->blocks as $block){
    printf("prevHash: %s\n",$block->prevHash);
    printf("Hash: %s\n",$block->hash);
    printf("Data: %s\n",$block->data);
    printf("Time: %s\n",$block->timestamp);
    printf("\n");
}
?>
