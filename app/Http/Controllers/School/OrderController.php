<?php


namespace App\Http\Controllers\School;


use App\Exceptions\CommonException;
use App\Http\Constans\School\OrderPlatform;
use App\Http\Models\School\Order;
use App\Http\Services\Head\SchoolOrderServices;
use Illuminate\Http\Request;

class OrderController
{
    public function list()
    {
        $searchData = \Request::all();
        $page = $searchData['pageSize'] ?? 15;
        if (isset($searchData['searchOrderId']))
        {
            $orderData = Order::query()
                ->leftJoin('semester','order.semester_id','=','semester.id')
                ->leftJoin('student','order.student_id','=','student.id')
                ->leftJoin('admins','order.operator_id','=','admins.id')
                ->where('order.school_id',$searchData['school_id'])
                ->where('order.id','like','%'.$searchData['searchOrderId'].'%')
                ->select('order.*','student.name as student_name',
                    'student.mobile as student_mobile','student.id as student_id',
                    'semester.name as semester_name','semester.id as semester_id','admins.name as admin_name')
                ->paginate($page);
        }else
        {
            $orderData = Order::query()
                ->leftJoin('semester','order.semester_id','=','semester.id')
                ->leftJoin('student','order.student_id','=','student.id')
                ->leftJoin('admins','order.operator_id','=','admins.id')
                ->where('order.school_id',$searchData['school_id'])
                ->select('order.*','student.name as student_name',
                    'student.mobile as student_mobile','student.id as student_id',
                    'semester.name as semester_name','semester.id as semester_id','admins.name as admin_name')
                ->paginate($page);
        }

        return $orderData;
    }

    //付款or退款
    public function create(Request $request,SchoolOrderServices $services)
    {
        $data = $request->all();
        if (empty($data['payment_order']['channel'])){
            throw new CommonException('Please choose the method of payment');
        }
        return $services->create(OrderPlatform::BACKSTAGE,$data);
    }


    public function detail(Request $request,SchoolOrderServices $services){
        $data = $request->all();
        return $services->detail($data);
    }

}
