<?php


namespace App\Http\Services\Classes;


use App\Exceptions\CommonException;
use App\Http\Constans\Head\StudentGender;
use App\Http\Constans\Head\StudentStauts;
use App\Http\Constans\School\CoursePlanStatus;
use App\Http\Constans\School\StudentRegisterAudit;
use App\Http\Constans\School\StudentRegisterStatus;
use App\Http\Models\Classes\CoursePlan;
use App\Http\Models\Classes\Grade;
use App\Http\Models\Head\Student;
use App\Http\Models\School\StudentRegister;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;

class ClassesStudentGradeServices
{
    public function input($data){
        try {
            DB::beginTransaction();

            foreach ($data['scores'] as $item){

                $grade_data = Grade::query()->where('student_id',$data['student_id'])
                    ->where('course_id',$item['course_id'])
                    ->where('class_id',$data['class_id'])
                    ->first();

                $updata = Arr::only($item, [
                    'course_id' ,
                    'score',
                ]);
                if ($updata['score'] > 100.00 || $updata['score'] < 0)
                {
                    throw new CommonException('The score is between 100 and 0');
                }
                $updata['operator_id'] = $data['operator_id'];
                $updata['class_id'] = $data['class_id'];
                $updata['student_id'] = $data['student_id'];

                if (empty($updata['score']))
                {
                    continue;
                }
                if($grade_data)
                {
                    $grade_data->update($updata);
                }
                else{
                    Grade::query()->create($updata);
                }

            }
            DB::commit();
            return 'success';

        }catch (CommonException $exception){

            DB::rollBack();
            throw $exception;
        }
    }

    public function detail($student_id,$class_id){
        $query  = StudentRegister::query()->leftJoin('student',function ($join){
            $join->on("student_register.student_id",'=',"student.id");
        })
            ->leftJoin('course_plan',function ($join) use ($class_id){
                $join->on("student_register.class_id",'=',"course_plan.class_id")
                ->where("course_plan.class_id",'=',$class_id);
            })
            ->leftJoin('course',function ($join){
                $join->on("course.id",'=','course_plan.course_id');
            })
            ->leftJoin('student_grade',function ($join) use($student_id,$class_id){
                $join->on("course.id",'=','student_grade.course_id')
                ->where("student_grade.student_id",'=',$student_id)
                ->where("student_grade.class_id",'=',$class_id);
            })
            ->leftJoin('semester',function ($join) use($class_id){
                $join->on("student_register.semester_id",'=',"semester.id");
            });
        $query->whereIn('student_register.status',[StudentRegisterStatus::REGISTER,StudentRegisterStatus::COMPLETE])
            ->where('student_register.class_id','<>',null)
            ->where('student_register.student_id',$student_id);
        $query->whereNotNull('course_plan.course_id')->where('course_plan.status',CoursePlanStatus::Reviewed);
        $query->select("student.id as student_id","student.name as student_name","course.name as course_name",
            "course.id as course_id","student_grade.score","semester.name as semester_name",
            "semester.end_date as semester_end_date","semester.id as semester_id")
            ->distinct();
       return $query->get()->toArray();
    }

    public function audit($data){
        $studentGradeItem = Grade::query()->where('class_id',$data['class_id'])->where('student_id',$data['student_id'])->count();

        $coursePlanItem = CoursePlan::query()->where('class_id',$data['class_id'])->where('status',CoursePlanStatus::Reviewed)
            ->distinct('course_id')->count('course_id');


        if ($studentGradeItem<$coursePlanItem){
            throw new CommonException('The score of the subject is not completed');
        }
        else{

            //每个科目都录入了设置为结业
            Student::query()->where('id',$data['student_id'])->update(['status'=>StudentStauts::GRADUATED]);
            //修改报名审核为已通过，结业
            StudentRegister::query()->where('class_id',$data['class_id'])->where('student_id',$data['student_id'])
                ->update(['audit' => StudentRegisterAudit::PASSED,'status' => StudentRegisterStatus::COMPLETE]);

        }
       return 'success';

    }
}
