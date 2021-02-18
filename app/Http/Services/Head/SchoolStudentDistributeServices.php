<?php


namespace App\Http\Services\Head;


use App\Http\Constans\School\StudentRegisterStatus;
use App\Http\Models\School\StudentDistribute;
use App\Http\Models\School\StudentRegister;
use FineYoga\LaravelBase\Exception\Exceptions\BusinessException;
use Illuminate\Support\Facades\DB;

class SchoolStudentDistributeServices
{
    public function remove($class_id,$student_id,$semester_id){
        try {
            DB::beginTransaction();
            StudentRegister::query()->where('student_id',$student_id)
                ->where('semester_id',$semester_id)
                ->where('class_id',$class_id)
                ->where('status','<',StudentRegisterStatus::COMPLETE)
                ->update(['class_id'=> null]);
            $query = StudentDistribute::query()->where('class_id',$class_id)->where('student_id',$student_id)->first();
            $query->delete();
            DB::commit();

            return 'success';

        } catch (\Exception $exception) {
            DB::rollBack();
        }
    }

    public function distribute($data){
        foreach ($data['student_id'] as $item){
            $query = StudentRegister::query()
                ->where('student_id',$item)
                ->where('semester_id',$data['semester_id'])
                ->where('class_id',null)
                ->where('status','<',StudentRegisterStatus::COMPLETE)
                ->first();
            $updata = $data;
            $updata['student_id'] = $item;
            $updata['operator_id'] = $data['admin_id'];
            if ($query){
                StudentDistribute::query()->create($updata);
                $query->update(['class_id' =>$data['class_id']]);
            }
            else
            {
                throw new BusinessException('The student did not register');
            }
        }
        return 'success';
    }
}
