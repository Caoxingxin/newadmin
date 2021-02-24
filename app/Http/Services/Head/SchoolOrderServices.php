<?php


namespace App\Http\Services\Head;


use App\Http\Constans\School\OrderPlatform;
use App\Http\Models\Auth\Admin;
use App\Http\Models\Head\Student;
use App\Http\Models\School\Order;
use App\Http\Models\School\PaymentOrder;

class SchoolOrderServices
{

    public function getOrderService ($platform) {

        $service = [
            OrderPlatform::BACKSTAGE => \App\Http\Services\Head\OrderServices::class
        ];
        return new $service[$platform];
    }

    public function create($platform,$data){
        $services = $this->getOrderService($platform);

        return $services->create($data);
    }

    public function detail($data){

        $orderData = Order::query()->find($data['id']);

        $orderData['student_name'] = Student::query()->where('id',$orderData['student_id'])->first()['name'];

        $adminData = Admin::query()->find($orderData['operator_id']);

        $orderData['admin_name'] = $adminData['name'];

        $orderData['payment_order'] = PaymentOrder::query()->select('channel', 'created_at', 'amount')->where('relation_id', $orderData['id'])->get();

        return $orderData;
    }
}
