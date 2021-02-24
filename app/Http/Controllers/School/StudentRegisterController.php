<?php


namespace App\Http\Controllers\School;


use App\Http\Controllers\Controller;
use App\Http\Models\School\StudentRegister;
use App\Http\Services\Head\SchoolStudentRegisterServices;
use Illuminate\Http\Request;


class StudentRegisterController extends Controller
{
    public function list(){
        $searchData = \Request::all();
        $page = $searchData['pageSize'] ?? 15;
        if (isset($searchData['searchStudentMobile']))
        {
            $StudentRegisterData = StudentRegister::query()
                ->leftJoin('student','student.id','=','student_register.student_id')
                ->leftJoin('class','class.id','=','student_register.class_id')
                ->leftJoin('semester','semester.id','=','student_register.semester_id')
                ->leftJoin('admins','admins.id','=','student_register.admin_id')
                ->where('student.mobile','like','%'.$searchData['searchStudentMobile'].'%')
                ->where('semester.school_id',$searchData['school_id'])
                ->select('student_register.*','class.name as class_name','semester.name as semester_name',
                    'student.id as student_id','student.name as student_name','student.mobile as student_mobile','admins.name as admin_name')
                ->paginate($page);
        }else
        {
            $StudentRegisterData = StudentRegister::query()
                ->leftJoin('student','student.id','=','student_register.student_id')
                ->leftJoin('class','class.id','=','student_register.class_id')
                ->leftJoin('semester','semester.id','=','student_register.semester_id')
                ->leftJoin('admins','admins.id','=','student_register.admin_id')
                ->where('semester.school_id',$searchData['school_id'])
                ->select('student_register.*','class.name as class_name','semester.name as semester_name',
                'student.id as student_id','student.name as student_name','student.mobile as student_mobile','admins.name as admin_name')
                ->paginate($page);
        }

        return $StudentRegisterData;
    }
    //添加报名
    public function create(Request $request,SchoolStudentRegisterServices $services){
        $data = $request->all();
        return $services->create($data);
    }
    //报名信息详情，里面包括有付款
    public function detail(Request $request,SchoolStudentRegisterServices $services){
        $id = $request->input('id');
        return $services->detail($id);
    }

    //报道
    public function report(Request $request,SchoolStudentRegisterServices $services){
        $data = $request->all();
        return $services->report($data);
    }

    //延期
    public function postpone(Request $request,SchoolStudentRegisterServices $services){
        $id = $request->input('id');
        $operate_id = $request->input('operate_id');
        $remark = $request->input('remark');
        return $services->postpone($id,$operate_id,$remark);
    }

    //取消报名
    public function cancelRegister(Request $request,SchoolStudentRegisterServices $services){
        $data = $request->all();
        return $services->cancelRegister($data);
    }


}
