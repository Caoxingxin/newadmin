<?php


namespace App\Http\Controllers\School;


use App\Http\Controllers\Controller;
use App\Http\Models\School\StudentDistribute;

class StudentDistributeController extends Controller
{
    public function list(){
        $searchData = \Request::all();
        $page = $searchData['pageSize'] ?? 15;
        if (isset($searchData['searchStudentMobile']))
        {
            $DistributeData = StudentDistribute::query()
                ->leftJoin('student','student.id','=','student_distribute.id')
                ->where('student_distribute.class_id',$searchData['class_id'])
                ->where('student.mobile','like',$searchData['searchStudentMobile'] . '%')
                ->select('student_distribute.*','student.name as student_name','student.mobile as student_mobile')
                ->paginate($page);
        }else
        {
            $DistributeData = StudentDistribute::query()
                ->leftJoin('student','student.id','=','student_distribute.id')
                ->where('student_distribute.class_id',$searchData['class_id'])
                ->select('student_distribute.*','student.name as student_name','student.mobile as student_mobile')
                ->paginate($page);
        }

        return $DistributeData;
    }

    public function distribute(){

    }

    public function remove(){

    }

    //未分班学生
    public function showList(){

    }
}
