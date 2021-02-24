<?php


namespace App\Http\Controllers\School;


use App\Http\Controllers\Controller;
use App\Http\Models\School\PaymentOrder;

class PaymentOrderController extends Controller
{
    public function list(){
        $searchData = \Request::all();
        $page = $searchData['pageSize'] ?? 15;
        if (isset($searchData['searchOrderId']))
        {
            $paymentData = PaymentOrder::query()
                ->leftJoin('order','order.id','=','payment_order.relation_id')
                ->where('order.student_id',$searchData['student_id'])
                ->where('order.semester_id',$searchData['semester_id'])
                ->where('order.school_id',$searchData['school_id'])
                ->where('payment_order.relation_id','like','%'.$searchData['searchOrderId'].'%')
                ->select('order.type as order_type','payment_order.*')
                ->paginate($page);
        }else
        {
            $paymentData = PaymentOrder::query()
                ->leftJoin('order','order.id','=','payment_order.relation_id')
                ->where('order.student_id',$searchData['student_id'])
                ->where('order.semester_id',$searchData['semester_id'])
                ->where('order.school_id',$searchData['school_id'])
                ->select('order.type as order_type','payment_order.*')
                ->paginate($page);
        }

        return $paymentData;
    }
}
