<?php


namespace App\Http\Constans\School;

use Carbon\Carbon;

class OrderNoGenerator
{
    //随机数生成订单编号
    public function getOrderId($action)
    {
        if ($action == 'order') return 10 . Carbon::now()->timestamp . rand(0, 9) . rand(0, 9) . rand(0, 9) . rand(0, 9);
        if ($action == 'paymentOrder') return 20 . Carbon::now()->timestamp . rand(0, 9) . rand(0, 9) . rand(0, 9) . rand(0, 9);
        return null;
    }
}
