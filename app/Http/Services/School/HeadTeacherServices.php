<?php


namespace App\Http\Services\School;


use App\Http\Constans\Head\TeacherStatus;
use App\Http\Models\Head\Teacher;
use Illuminate\Support\Facades\DB;

class HeadTeacherServices
{
    public function detail($id){
        $teacherData = Teacher::query()->find($id);
        return $teacherData;
    }

    public function create($data){
        try {
            DB::beginTransaction();
            $school = Teacher::query()->create($data);
            DB::commit();
            return $school->toArray();

        } catch (\Exception $exception) {
            DB::rollBack();
        }
    }

    public function update($data){
        $teacherData = Teacher::query()->where('id',$data['id'])->first();
        try {
            DB::beginTransaction();
            $teacherData->update($data);
            DB::commit();
            return 'success';

        } catch (\Exception $exception) {
            DB::rollBack();
        }
    }

    public function delete($id){
        try {
            DB::beginTransaction();
            $query = Teacher::query()->find($id);
            $query->delete();
            DB::commit();

            return 'success';

        } catch (\Exception $exception) {
            DB::rollBack();
        }
    }

    public function status($status,$id,$full_time){
        try {
            DB::beginTransaction();
            $query = Teacher::query()->find($id);
            if ($status == TeacherStatus::Trial) {
                $query->update(['status' => TeacherStatus::Official,'full_time'=>$full_time]);
            };
            DB::commit();

            return 'success';

        } catch (\Exception $exception) {
            DB::rollBack();
        }
    }
}
