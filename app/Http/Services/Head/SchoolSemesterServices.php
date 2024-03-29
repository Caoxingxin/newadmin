<?php


namespace App\Http\Services\Head;


use App\Http\Constans\School\SemesterStatus;
use App\Http\Models\Head\Course;
use App\Http\Models\School\Semester;
use Illuminate\Support\Facades\DB;

class SchoolSemesterServices
{
    public function create($data){
        try {
            DB::beginTransaction();
            $school = Semester::query()->create($data);
            DB::commit();
            return $school->toArray();

        } catch (\Exception $exception) {
            DB::rollBack();
        }
    }

    public function update($data){
        $semesterData = Semester::query()->where('id',$data['id'])->first();
        try {
            DB::beginTransaction();
            $semesterData->update($data);
            DB::commit();
            return 'success';

        } catch (\Exception $exception) {
            DB::rollBack();
        }
    }

    public function detail($id){
        $semesterData = Semester::query()->find($id);
        return $semesterData;
    }

    public function delete($id){
        try {
            DB::beginTransaction();
            $query = Semester::query()->find($id);
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
            $query = Semester::query()->find($id);
            if ($status == SemesterStatus::ONLINE) {
                $query->update(['status'=>SemesterStatus::OFFLINE]);
            }else{
                $query->update(['status'=>SemesterStatus::ONLINE]);
            }

            DB::commit();

            return 'success';

        } catch (\Exception $exception) {
            DB::rollBack();
        }
    }
}
