<?php


namespace App\Http\Controllers\Classes;


use App\Http\Controllers\Controller;
use App\Http\Models\School\StudentDistribute;
use App\Http\Services\School\HeadStudentServices;
use Illuminate\Http\Request;

class ClassesStudentController extends Controller
{
    public function list(){
        $searchData = \Request::all();
        $page = $searchData['pageSize'] ?? 15;
        if (isset($searchData['searchStudentMobile'])) {

            $StudentData = StudentDistribute::query()
                ->leftJoin('student','student.id','=','student_distribute.student_id')
                ->where('student_distribute.class_id',$searchData['class_id'])
                ->where('student.mobile', 'like', $searchData['searchStudentMobile'] . '%')
                ->select('student.*','student_distribute.*')
                ->paginate($page);
        }else{
            $StudentData = StudentDistribute::query()
                ->leftJoin('student','student.id','=','student_distribute.student_id')
                ->where('student_distribute.class_id',$searchData['class_id'])
                ->select('student.*','student_distribute.*')
                ->paginate($page);
        }
        return $StudentData;
    }

    public function detail(Request $request,HeadStudentServices $services){
        $id = $request->input('student_id');
        return $services->detail($id);
    }


}
