<?php


namespace App\Http\Services\Head;


use App\Exceptions\CommonException;
use App\Http\Constans\Head\StudentStauts;
use App\Http\Constans\School\StudentRegisterStatus;
use App\Http\Models\Head\Student;
use App\Http\Models\School\Semester;
use App\Http\Models\School\Student_School;
use App\Http\Models\School\StudentRegister;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\DB;

class SchoolStudentRegisterServices
{
    public function create($data){
        try {
            DB::beginTransaction();
            $semesterData = Semester::query()->find($data['semester_id']);
            if ($semesterData['register_end_at'] < date('Y-m-d')){
                throw new CommonException('Registration time is over');
            }
            $data['tuition'] = $semesterData['tuition'];

            $studentData = Student::query()->where('mobile',$data['mobile'])->first();

            if ($semesterData['number'] < ($semesterData['registered_number'] + 1)){
                throw new CommonException('Quota is full');
            }

            $memberData = [
                'name' => $data['name'],
                'mobile' => $data['mobile'],
                'gender' => $data['gender'],
                'status' => StudentStauts::ORDINARY
            ];
            if ($studentData ){
                $school_student = Student_School::query()->where('student_id',$studentData['id'])->where('school_id',$data['school_id'])->first();
                $data['student_id'] = $studentData['id'];
                $studentRegisterData = StudentRegister::query()
                    ->where('student_id',$studentData['id'])
                    ->where('semester_id',$data['semester_id'])
                    ->where('status','<',StudentRegisterStatus::COMPLETE)
                    ->first();
                if ($studentRegisterData){
                    throw new CommonException('Has enrolled for the semester');
                }
                $studentData->update($memberData);
                if (!$school_student){
                    Student_School::query()->create(['school_id' => $data['school_id'],'student_id'=>$studentData['id']]);
                }
            }
            else{
                $newStudentData = Student::query()->create($memberData);
                $data['student_id'] = $newStudentData['id'];
                Student_School::query()->create(['school_id' => $data['school_id'],'student_id'=>$newStudentData['id']]);
            }
//            DB::update('update semester set registered_number = registered_number + 1 where id = ?', [$data['semester_id']]);
            $semesterData->update(['registered_number'=>($semesterData['registered_number']+1)]);
            $result = StudentRegister::query()->create($data);
            DB::commit();

            return $result;

        }catch (CommonException $exception){
            DB::rollBack();
            throw $exception;
        }
    }

    public function postpone($id,$operate_id,$remark){
        try {
            DB::beginTransaction();

            $query = StudentRegister::query()->find($id);
            $update = [
                'status' => StudentRegisterStatus::DELAY,
                'operator_id' => $operate_id
            ];
            if (!empty($remark)) $update = array_merge($update, ['remark' => $remark]);
            $query->update($update);

            DB::commit();

            return $query;

        }catch (CommonException $exception){
            DB::rollBack();
            throw $exception;
        }
    }

    public function report($data){
        try {
            DB::beginTransaction();

            $studentRegister = StudentRegister::query()->find($data['id']);
//            $semester = Semester::query()->find($data['semester_id']);
            //验证款项是否有余
            if ($studentRegister['tuition'] > $studentRegister['tuition_paid'])
                throw new CommonException('The fee has not been settled, please inform the member to pay the fee before confirming the report');

            $studentRegister->update(['status' => StudentRegisterStatus::REGISTER,'operator_id' => $data['operator_id']]);

            DB::commit();

            return $studentRegister;
        }catch (CommonException $exception){
            DB::rollBack();
            throw $exception;
        }
    }

    public function cancelRegister($data) {
        try {
            DB::beginTransaction();

            $studentRegister = StudentRegister::query()->find($data['id']);
            $studentRegister->update(['status' => StudentRegisterStatus::CANCELLED,'operator_id'=>$data['operator_id']]);
            //学期释放名额
            $semester = Semester::query()->find($data['semester_id']);
            $semester->update(['registered_number' => ($semester['registered_number'] - 1)]);

            DB::commit();
            return $studentRegister;
        }catch (CommonException $exception){
            DB::rollBack();
            throw $exception;
        }

    }

    public function detail($id){
        $studentRegister = StudentRegister::query()->find($id);
        $semester = Semester::query()->find($studentRegister['semester_id']);
//        $student = Student::query()->find($studentRegister['student_id']);
        $student = json_decode(\Redis::hget('student',$studentRegister['student_id']),true);
        $res = array_merge($this->registerCost($id), [
            'id' => $studentRegister['id'],
            'semester_id' => $semester['id'],
            'student_id' => $student['id'],
            'semester_name' => $semester['name'],
            'student_name' => $student['name'],

            'student_mobile' => $student['mobile'],
            'student_gender' => $student['gender'],
//            'earnest' => $semester['earnest'],
//            'deposit' => $semester['deposit'],
//            'register_mode' => $semester['register_mode'],
            'remark' => $studentRegister['remark'],
            'status' => $studentRegister['status'],
        ]);
        return $res;
    }

    //计算费用
    public function registerCost($id){
        $studentRegister = StudentRegister::query()->find($id);
        $semester = Semester::query()->find($studentRegister['semester_id']);
        $data = [
            'tuition' => $semester['tuition'],
            'tuition_paid' => $studentRegister['tuition_paid'],
            'tuition_wait' => $semester['tuition'] - $studentRegister['tuition_paid'],
            'tuition_refund' => $studentRegister['tuition_refund'],
            'all' =>  $semester['tuition'],
            'all_paid' => $studentRegister['tuition_paid'],
            'all_wait' => $semester['tuition'] - $studentRegister['tuition_paid'],
        ];
        return $data;
    }
}
