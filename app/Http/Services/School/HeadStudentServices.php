<?php


namespace App\Http\Services\School;


use App\Http\Models\Head\Student;
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


}
