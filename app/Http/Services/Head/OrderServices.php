<?php


namespace App\Http\Services\Head;


use App\Exceptions\CommonException;
use App\Http\Constans\School\OrderNoGenerator;
use App\Http\Constans\School\OrderStatus;
use App\Http\Constans\School\OrderType;
use App\Http\Constans\School\StudentRegisterStatus;
use App\Http\Models\School\Order;
use App\Http\Models\School\PaymentOrder;
use App\Http\Models\School\Semester;
use App\Http\Models\School\StudentRegister;
use Illuminate\Support\Facades\DB;

class OrderServices
{
    public function create($data){
        try {
            DB::beginTransaction();

            $semester = Semester::query()->find($data['semester_id']);
            $studentRegister = StudentRegister::query()
                ->where('student_id',$data['student_id'])
                ->where('semester_id',$data['semester_id'])
                ->where('status','<',StudentRegisterStatus::COMPLETE)
                ->first();
            if ($data['type'] == OrderType::PAY && $data['actual_total'] > $data['tuition_wait'])
                throw new CommonException('Tuition fee must not be greater than', ['tuition' => $data['tuition_wait']]);
            if ($data['type'] == OrderType::REFUND && $data['actual_total'] > $data['tuition_paid'])
                throw new CommonException('Tuition fee must not be greater than', ['tuition' => $data['tuition_paid']]);

            $orderData['id'] = resolve(OrderNoGenerator::class)->getOrderId('order');
            $orderData['school_id'] = $semester['school_id'];
            $orderData['semester_id'] = $data['semester_id'];
            $orderData['student_id'] = $data['student_id'];
            $orderData['total'] = $orderData['actual_total'] = $data['actual_total'];
            $orderData['type'] = $data['type'];
            $orderData['operator_id'] = $data['operate_id'];
            $orderData['platform'] = $data['platform'];
            $orderData['status'] = OrderStatus::COMPLETED; //待修改
            $orderData['remark'] = $data['remark'];

            $order = Order::query()->create($orderData);

            $paymentOrderData= array_merge($data['payment_order'],[
                'relation_id' => $order['id'],
                'school_id' => $semester['school_id'],
                'student_id' => $data['student_id'],
                'status' => 10,
                'platform' => 1
            ]);
            $paymentOrderData['id'] = resolve(OrderNoGenerator::class)->getOrderId('paymentOrder');

            PaymentOrder::query()->create($paymentOrderData);
            //order和paymentorder都成功后跟新报名表
            if ($data['type'] == OrderType::PAY){
                $studentRegister->update(['tuition_paid'=>$studentRegister['tuition_paid']+$order['actual_total']]);
            }
            else{
                $studentRegister->update([
                    'tuition_paid'=>$studentRegister['tuition_paid']-$order['actual_total'],
                    'tuition_refund'=>$studentRegister['tuition_refund']+$order['actual_total']
                ]);
            }

            DB::commit();

            return $order;
        }catch (CommonException $exception){
            DB::rollBack();
            throw $exception;
        }
    }
}
