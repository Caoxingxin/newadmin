<?php


namespace App\Http\Controllers\Classes;


use App\Http\Constans\School\StudentRegisterStatus;
use App\Http\Controllers\Controller;
use App\Http\Models\Classes\Grade;
use App\Http\Models\Head\Student;
use App\Http\Services\Classes\ClassesStudentGradeServices;
use Illuminate\Http\Request;

class ClassesStudentGradeController extends Controller
{
    public function list(Request $request){
        $searchData = $request->all();
        $school_id = null;
        $class_id = $searchData['class_id'];
        $page = $searchData['pageSize'] ?? 15;
        if (isset($searchData['searchStudentMobile'])) {

            $StudentData = Student::query()
                ->leftJoin('student_register','student.id','=','student_register.student_id')
                ->whereIn('student_register.status',[StudentRegisterStatus::REGISTER,StudentRegisterStatus::COMPLETE])
                ->whereNotNull('student_register.class_id')

                ->leftJoin('student_grade',function ($join)use($class_id){
                    $join->on('student.id','=','student_grade.student_id')
                        ->where('student_grade.class_id',$class_id);
                })
                ->leftJoin('student_distribute',function ($join){
                    $join->on('student.id','=','student_distribute.student_id')
                        ->where('student_distribute.class_id','student_register.class_id');
                })

                ->leftJoin('semester','student_register.semester_id','=','semester.id')
                ->leftJoin('class','student_register.class_id','=','class.id')
                ->leftJoin('admins','admins.id','=','student_grade.operator_id')
                ->where('student_register.class_id',$class_id)
                ->where('student.mobile', 'like', $searchData['searchStudentMobile'] . '%')
                ->select('semester.name as semester_name',
                    'class.name as class_name',
                    'student.name as student_name',
                    'student.id',
                    'student.mobile as student_mobile',
                    'student_grade.score as student_score',
                    'student_grade.operator_id',
                    'class.id as class_id',
                    'student_register.audit',
                    'admins.name as admins_name'
                )
                ->distinct()
                ->paginate($page);
        }else{
            $StudentData = Student::query()
                ->leftJoin('student_register','student.id','=','student_register.student_id')
                ->whereIn('student_register.status',[StudentRegisterStatus::REGISTER,StudentRegisterStatus::COMPLETE])
                ->whereNotNull('student_register.class_id')

                ->leftJoin('student_grade',function ($join)use($class_id){
                    $join->on('student.id','=','student_grade.student_id')
                        ->where('student_grade.class_id',$class_id);
                })
                ->leftJoin('student_distribute',function ($join){
                    $join->on('student.id','=','student_distribute.student_id')
                        ->where('student_distribute.class_id','student_register.class_id');
                })

                ->leftJoin('semester','student_register.semester_id','=','semester.id')
                ->leftJoin('class','student_register.class_id','=','class.id')
                ->leftJoin('admins','admins.id','=','student_grade.operator_id')
                ->where('student_register.class_id',$class_id)
                ->select('semester.name as semester_name',
                    'class.name as class_name',
                    'student.name as student_name',
                    'student.id',
                    'student.mobile as student_mobile',
                    'student_grade.operator_id',
                    'class.id as class_id',
                    'student_register.audit',
                    'admins.name as admins_name'
                )
                ->distinct()
                ->paginate($page);
//            ->toSql();
//            dd($StudentData);
        }
        foreach ($StudentData as $item){
            $query = Grade::query()->where('class_id', $class_id)->where('student_id', $item['id'])->where('score','>',0)->get();
            $score = $query->avg('score');

            if ($score) {
                $item['score'] = round($score,2);
            } else {
                $item['score'] = 0.00;
            }
        }
        return $StudentData;
    }

    public function input(Request $request,ClassesStudentGradeServices $services){

        $data = $request->all();

        return $services->input($data);

    }

    public function detail(Request $request,ClassesStudentGradeServices $services){
        $student_id = $request->input('student_id');
        $class_id = $request->input('class_id');

        return $services->detail($student_id,$class_id);
    }

    public function audit(Request $request,ClassesStudentGradeServices $services){
        $data = $request->all();
        return $services->audit($data);
    }
}
