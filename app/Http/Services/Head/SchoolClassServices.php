<?php


namespace App\Http\Services\Head;


use App\Http\Constans\School\ClassesStatus;
use App\Http\Models\School\Classes;
use Illuminate\Support\Facades\DB;

class SchoolClassServices
{
    public function create($data){
        try {
            DB::beginTransaction();
            $classData = Classes::query()->create($data);
            DB::commit();
            return $classData->toArray();

        } catch (\Exception $exception) {
            DB::rollBack();
        }
    }

    public function update($data){
        $classData = Classes::query()->where('id',$data['id'])->first();
        try {
            DB::beginTransaction();
            $classData->update($data);
            DB::commit();
            return 'success';

        } catch (\Exception $exception) {
            DB::rollBack();
        }
    }

    public function detail($id){
        $classData = Classes::query()->find($id);
        return $classData;
    }

    public function delete($id){
        $query = Classes::query()->find($id);
        $query->delete();

        return 'success';
    }

    public function status($status,$id){
        try {
            DB::beginTransaction();
            $query = Classes::query()->find($id);
            if ($status == ClassesStatus::ENABLE) {
                $query->update(['status'=>ClassesStatus::DISABLE]);
            }else{
                $query->update(['status'=>ClassesStatus::ENABLE]);
            }

            DB::commit();

            return 'success';

        } catch (\Exception $exception) {
            DB::rollBack();
        }
    }
}
