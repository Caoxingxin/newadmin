<?php


namespace App\Http\Controllers\School;


use App\Http\Constans\School\StudentRegisterStatus;
use App\Http\Controllers\Controller;
use App\Http\Models\Head\Student;
use App\Http\Models\School\StudentDistribute;
use App\Http\Services\Head\SchoolStudentDistributeServices;
use Illuminate\Http\Request;

class StudentDistributeController extends Controller
{
    public function list()
    {
        $searchData = \Request::all();
        $page = $searchData['pageSize'] ?? 15;
        if (isset($searchData['searchStudentMobile'])) {
            $DistributeData = StudentDistribute::query()
                ->leftJoin('student', 'student.id', '=', 'student_distribute.student_id')
                ->leftJoin('admins','student_distribute.operator_id','=','admins.id')
                ->where('student_distribute.class_id', $searchData['class_id'])
                ->where('student.mobile', 'like', $searchData['searchStudentMobile'] . '%')
                ->select('student_distribute.*', 'student.name as student_name', 'student.mobile as student_mobile','admins.name as admin_name')
                ->paginate($page);
        } else {
            $DistributeData = StudentDistribute::query()
                ->leftJoin('student', 'student.id', '=', 'student_distribute.student_id')
                ->leftJoin('admins','student_distribute.operator_id','=','admins.id')
                ->where('student_distribute.class_id', $searchData['class_id'])
                ->select('student_distribute.*', 'student.name as student_name', 'student.mobile as student_mobile','admins.name as admin_name')
                ->paginate($page);
        }

        return $DistributeData;
    }

    public function distribute(Request $request,SchoolStudentDistributeServices $services)
    {
        $data = $request->all();
        return $services->distribute($data);
    }

    public function remove(Request $request,SchoolStudentDistributeServices $services)
    {
        $class_id = $request->input('class_id');
        $student_id = $request->input('student_id');
        $semester_id = $request->input('semester_id');
        return $services->remove($class_id,$student_id,$semester_id);
    }

    //未分班学生
    public function showList()
    {
        $searchData = \Request::all();
        $page = $searchData['pageSize'] ?? 15;
        if (isset($searchData['searchStudentMobile'])) {
            $NotDistributeData = Student::query()
                ->leftJoin('student_school','student.id','=','student_school.student_id')
                ->where('student_school.school_id','=',$searchData['school_id'])
                ->leftJoin('student_register','student.id','=','student_register.student_id')
                ->where('student_register.semester_id','=',$searchData['semester_id'])
                ->where('student_register.class_id','=',null)
                ->where('student_register.status',StudentRegisterStatus::REGISTER)
                ->where('student_register.student_id','<>',null)
                ->where('student.mobile', 'like', $searchData['searchStudentMobile'] . '%')
                ->paginate($page);
        } else {
            $NotDistributeData = Student::query()
                ->leftJoin('student_school','student.id','=','student_school.student_id')
                ->where('student_school.school_id','=',$searchData['school_id'])
                ->leftJoin('student_register','student.id','=','student_register.student_id')
                ->where('student_register.semester_id','=',$searchData['semester_id'])
                ->where('student_register.class_id','=',null)
                ->where('student_register.status',StudentRegisterStatus::REGISTER)
                ->where('student_register.student_id','<>',null)
                ->paginate($page);
        }

        return $NotDistributeData;
    }
}
