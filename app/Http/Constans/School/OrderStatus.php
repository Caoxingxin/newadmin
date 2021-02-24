<?php


namespace App\Http\Constans\School;


class OrderStatus
{
    const OBLIGATION = 0;   //待付款
    const COMPLETED = 10;   //已完成
    const CANCELLED = -10;  //已取消
    const PAYING = 8;       //支付中
}
