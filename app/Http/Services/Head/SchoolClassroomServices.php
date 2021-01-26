<?php


namespace App\Http\Services\Head;


use App\Http\Constans\School\ClassroomStatus;
use App\Http\Models\School\Classroom;
use Illuminate\Support\Facades\DB;

class SchoolClassroomServices
{
    public function create($data){
        try {
            DB::beginTransaction();
            $classroomData = Classroom::query()->create($data);
            DB::commit();
            return $classroomData->toArray();

        } catch (\Exception $exception) {
            DB::rollBack();
        }
    }

    public function update($data){
        $classroomData = Classroom::query()->where('id',$data['id'])->first();
        try {
            DB::beginTransaction();
            $classroomData->update($data);
            DB::commit();
            return 'success';

        } catch (\Exception $exception) {
            DB::rollBack();
        }
    }

    public function detail($id){
        $classroomData = Classroom::query()->find($id);
        return $classroomData;
    }

    public function delete($id){
        try {
            DB::beginTransaction();
            $query = Classroom::query()->find($id);
            $query->delete();
            DB::commit();

            return 'success';

        } catch (\Exception $exception) {
            DB::rollBack();
        }
    }

    public function status($status,$id){
        try {
            DB::beginTransaction();
            $query = Classroom::query()->find($id);
            if ($status == ClassroomStatus::ONLINE) {
                $query->update(['status'=>ClassroomStatus::OFFLINE]);
            }else{
                $query->update(['status'=>ClassroomStatus::ONLINE]);
            }

            DB::commit();

            return 'success';

        } catch (\Exception $exception) {
            DB::rollBack();
        }
    }
}
