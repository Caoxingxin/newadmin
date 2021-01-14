<?php


namespace App\Http\Services\School;


use App\Http\Constans\School\CourseStatus;
use App\Http\Models\Head\Course;
use Illuminate\Support\Facades\DB;

class HeadCourseServices
{
    public function create($data){
        try {
            DB::beginTransaction();
            $school = Course::query()->create($data);
            DB::commit();
            return $school->toArray();

        } catch (\Exception $exception) {
            DB::rollBack();
        }
    }

    public function detail($id){
        $schoolData = Course::query()->find($id);
        return $schoolData;
    }

    public function update($data){
        $courseData = Course::query()->where('id',$data['id'])->first();
        try {
            DB::beginTransaction();
            $courseData->update($data);
            DB::commit();
            return 'success';

        } catch (\Exception $exception) {
            DB::rollBack();
        }
    }

    public function status($status,$id){
        try {
            DB::beginTransaction();
            $query = Course::query()->find($id);
            if ($status == CourseStatus::NORMAL) {
                $query->update(['status'=>CourseStatus::DISABLE]);
            }else{
                $query->update(['status'=>CourseStatus::NORMAL]);
            }

            DB::commit();

            return 'success';

        } catch (\Exception $exception) {
            DB::rollBack();
        }
    }

    public function delete($id){
        try {
            DB::beginTransaction();
            $query = Course::query()->find($id);
            $query->delete();
            DB::commit();

            return 'success';

        } catch (\Exception $exception) {
            DB::rollBack();
        }
    }
}
