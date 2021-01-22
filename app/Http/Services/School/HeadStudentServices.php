<?php


namespace App\Http\Services\School;


use App\Http\Models\Head\Student;
use App\Http\Models\School\Student_School;
use Illuminate\Support\Facades\DB;

class HeadStudentServices
{
    public function detail($id){
        $studentData = Student::query()->find($id);
        return $studentData;
    }

    public function update($data){
        $studentData = Student::query()->where('id',$data['id'])->first();
        try {
            DB::beginTransaction();
            $studentData->update($data);
            DB::commit();
            return 'success';

        } catch (\Exception $exception) {
            DB::rollBack();
        }
    }

    public function create($data){
        try {
            DB::beginTransaction();
            $studentData = Student::query()->create($data);
            Student_School::query()->create(['school_id'=>$data['school_id'],'student_id'=>$studentData['id']]);
            DB::commit();
            return $studentData->toArray();

        } catch (\Exception $exception) {
            DB::rollBack();
        }
    }
}
