<?php


namespace App\Http\Services\School;


use App\Http\Constans\School\SchoolStatus;
use App\Http\Models\Head\School;
use Illuminate\Support\Facades\DB;

class HeadSchoolServices
{
    public function status($status,$id)
    {
        try {
            DB::beginTransaction();
            $query = School::query()->find($id);
            if ($status == SchoolStatus::operating) {
               $query->update(['status'=>SchoolStatus::pause]);
            }else{
                $query->update(['status'=>SchoolStatus::operating]);
            }

            DB::commit();

            return 'success';

        } catch (\Exception $exception) {
            DB::rollBack();
        }

    }

    public function create($data){
        try {
            DB::beginTransaction();
            $school = School::create($data);
            DB::commit();
            return $school->toArray();

        } catch (\Exception $exception) {
            DB::rollBack();
        }
    }

    public function detail($id){
        $schoolData = School::query()->find($id);
        return $schoolData;
    }

    public function update($data){
        $schoolData = School::query()->where('id',$data['id'])->first();
        try {
            DB::beginTransaction();
            $schoolData->update($data);
            DB::commit();
            return 'success';

        } catch (\Exception $exception) {
            DB::rollBack();
        }
    }
}
