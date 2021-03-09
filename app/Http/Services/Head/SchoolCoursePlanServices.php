<?php


namespace App\Http\Services\Head;


use App\Exceptions\CommonException;
use App\Http\Constans\School\CoursePlanStatus;
use App\Http\Models\Classes\CoursePlan;
use App\Http\Models\Head\Course;
use App\Http\Models\Head\Teacher;
use App\Http\Models\School\Classes;
use App\Http\Models\School\Semester;
use App\Http\Models\School\StudentDistribute;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class SchoolCoursePlanServices
{
    private $data = [];

    public function create($data){
        try {
            DB::beginTransaction();

            //判断教室人数是否能容纳班级人数
            $this->ifClassroomNum($data['max_num'],$data['class_id']);
            //判断结束时间
            if ($data['end_at'] <= $data['start_at']) {
                throw new CommonException('endTime cannot be less than startTime');
            }
            //获取学期结束时间
            $semesterEndDate = $this->getSemesterEndDate($data['class_id']);

            $createVerify = function ($data){

                //判断日期是否小于当前日期
                if ($data['date'] < date('Y-m-d')) {
                    throw new CommonException('The date cannot be less than the current date');
                }
                //判断教师在该时间内是否空闲
                $teacherStatus = $this->ifTeacherleisure($data);

                //判断同一时间教室是否被占用
                $classroomconflict = $this->ifClassroomconflict($data);

                //判断上课时间是否冲突
                $resultsql = CoursePlan::query()
                    ->where('class_id', $data['class_id'])
                    ->where('status', '<>', CoursePlanStatus::Cancelled);
                $this->ifDateTime($resultsql,  $data['start_time'], $data['end_time']);
                $classtimeconfilict = $resultsql->first();
                if ($classtimeconfilict) {
                    $msg = 'business.Class time conflict';
                    $error_data['course_name'] = Course::query()->where('id', $classtimeconfilict->course_id)->value('name');
                    $error_data['teacher_name'] = Teacher::query()->where('id', $classtimeconfilict->teacher_id)->value('name');
                    $error_data['time'] = $classtimeconfilict->start_at . '~' . $classtimeconfilict->end_at;

                    $this->data[] = trans($msg, ['teacher_name' => $error_data['teacher_name'], 'course_name' => $error_data['course_name'], 'time' => $error_data['time']]);
                }

                if ($teacherStatus || $classroomconflict || $classtimeconfilict) {
                    throw new CommonException('Arranging the conflict',  array_merge($this->data,['status' => -1]));
                }

                $plandata = [
                    'class_id' => $data['class_id'],
                    'course_id' => $data['course_id'],
                    'teacher_id' => $data['teacher_id'],
                    'classroom_id' => $data['classroom_id'],
                    'max_number' => $data['max_num'],
                    'start_at' => $data['start_time'],
                    'end_at' => $data['end_time'],
                    'operator_id' => $data['operate_id']
                ];

                return CoursePlan::query()->create($plandata);
            };

            //true为单日，false为周期
            if ($data['date_type']){

                $date = $data['date'];
                //判断是否在学期内排课
                if($date >= $semesterEndDate)
                {
                    throw new CommonException('Schedule more time than training',['semesterEndDate'=>$semesterEndDate]);
                }
                //合并时间
                $this->setDateTime($data, $date, $data['start_at'], $data['end_at']);

                $courseplan[] = $createVerify($data);

            }else{
                //周期排课
                $startDate = $data['start_date'];
                $endDate = $data['end_date'];

                $date = $startDate;
                do {
                    //判断是否在学期内排课
                    if($date >= $semesterEndDate)
                    {
                        throw new CommonException('Schedule more time than training',['semesterEndDate'=>$semesterEndDate]);
                    }
                        $currentDate = Date('Y-m-d', strtotime($date));
                        $data['start_time'] = $currentDate . ' ' .  $data['start_at'];
                        $data['end_time'] = $currentDate . ' ' . $data['end_at'];
                        $data['date'] = $currentDate;
                        $courseplan[] = $createVerify($data);
                        $date = date("Y-m-d", strtotime("+1 day", strtotime($date)));
                } while ($date <= $endDate);
            }

            DB::commit();
            if (!isset($courseplan)) {
                $courseplan = null;
                throw new CommonException('The period is not within a period of time');
            }
            return $courseplan;

        }catch (CommonException $exception){

            DB::rollBack();
            throw $exception;

        }

    }

    public function update($data){
        //拿到对应记录
        $courseplan = CoursePlan::query()->where('id', $data['id'])->first();

        $startTime = $data['start_at'];
        $endTime = $data['end_at'];
        $date = $data['date'];

        //判断教室人数是否能容纳班级人数
        $this->ifClassroomNum($data['max_num'],$data['class_id']);
        //判断结束时间
        if ($data['end_at'] <= $data['start_at']) {
            throw new CommonException('endTime cannot be less than startTime');
        }
        //获取学期结束时间
        $semesterEndDate = $this->getSemesterEndDate($data['class_id']);
        //判断是否在学期内排课
        if($date >= $semesterEndDate)
        {
            throw new CommonException('Schedule more time than training',['semesterEndDate'=>$semesterEndDate]);
        }
        //合并时间
        $this->setDateTime($data, $date, $data['start_at'], $data['end_at']);
        $data['start_at'] = $data['start_time'];
        $data['end_at'] = $data['end_time'];

        $courseplan->fill($data);
        $dirty = $courseplan->getDirty();
        //判断日期是否小于当前日期
        if ($data['date'] < date('Y-m-d H:i:s')) {
            throw new CommonException('The date cannot be less than the current date');
        }
        if (array_key_exists('coach_id', $dirty) || array_key_exists('classroom_id', $dirty)
            || array_key_exists('start_at', $dirty) || array_key_exists('end_at', $dirty))
        {
            //判断教师在该时间内是否空闲
            $teacherStatus = $this->ifTeacherleisure($data,$data['id']);

            //判断同一时间教室是否被占用
            $classroomconflict = $this->ifClassroomconflict($data,$data['id']);

            //判断上课时间是否冲突
            $resultsql = CoursePlan::query()
                ->where('id', '<>', $data['id'])
                ->where('class_id', $data['class_id'])
                ->where('status', '<>', CoursePlanStatus::Cancelled);
            $this->ifDateTime($resultsql,  $data['start_time'], $data['end_time']);
            $classtimeconfilict = $resultsql->first();
            if ($classtimeconfilict) {
                $msg = 'business.Class time conflict';
                $error_data['course_name'] = Course::query()->where('id', $classtimeconfilict->course_id)->value('name');
                $error_data['teacher_name'] = Teacher::query()->where('id', $classtimeconfilict->teacher_id)->value('name');
                $error_data['time'] = $classtimeconfilict->start_at . '~' . $classtimeconfilict->end_at;

                $this->data[] = trans($msg, ['teacher_name' => $error_data['teacher_name'], 'course_name' => $error_data['course_name'], 'time' => $error_data['time']]);
            }

        }
        if (isset($teacherStatus) || isset($classroomconflict) || isset($classtimeconfilict)) {
            throw new CommonException('Arranging the conflict', array_merge($this->data,['status' => -1]));
        }
        $data = [
            'id' => $data['id'],
            'class_id' => $data['class_id'],
            'course_id' => $data['course_id'],
            'teacher_id' => $data['teacher_id'],
            'classroom_id' => $data['classroom_id'],
            'max_number' => $data['max_num'],
            'start_at' => $data['start_time'],
            'end_at' => $data['end_time'],
            'operator_id' => $data['operate_id']
        ];
//     dd($courseplan);
        $courseplan->save($data);

        return 'success';

    }

    public function detail($id){
        $courseplan = CoursePlan::query()->where('id', $id)->first();
        if (!$courseplan) throw new CommonException('course-plan dose not exists');

        $courseplan['date'] = date('Y-m-d', strtotime($courseplan['start_at']));

        $courseplan['start_at'] = Carbon::parse($courseplan['start_at'])->format('H:i');
        $courseplan['end_at'] = Carbon::parse($courseplan['end_at'])->format('H:i');
        $courseplan['max_num'] = $courseplan['max_number'];
        return $courseplan;
    }

    public function check($ids){
        foreach ($ids as $id){
            $query = CoursePlan::query()->where('status',CoursePlanStatus::NOReviewed)->where('id',$id)->first();
            if(!$query)
            {
                continue;
            }

            $query->update(['status' => CoursePlanStatus::Reviewed]);
        }
        return 'success';
    }

    public function cancel($id){

        $record = CoursePlan::query()->where('id',$id)->first();
        try {
            DB::beginTransaction();
            $record->update(['status' => CoursePlanStatus::Cancelled]);
            DB::commit();
            return 'success';

        } catch (\Exception $exception) {
            DB::rollBack();
        }
    }


    //判断教室人数是否能容纳班级人数
    public function ifClassroomNum($max_number,$class_id){
        $classNum = StudentDistribute::query()->where('class_id',$class_id)->count();
        if($max_number<$classNum)
        {
            throw new CommonException('The classroom cannot hold a class');
        }
    }
    //获取学期结束时间
    public function getSemesterEndDate($class_id){
        $semesterId = Classes::query()->find($class_id)['semester_id'];
        $semesterEndDate = Semester::query()->select('end_date')->where('id',$semesterId)->first()['end_date'];
        $semesterEndDate =  date("Y-m-d",strtotime("+1 day",strtotime($semesterEndDate)));
        return $semesterEndDate;
    }

    private function ifTeacherleisure($data, $id = 0)
    {
        if ($id) {
            $resultsql = CoursePlan::query()
                ->where('teacher_id', $data['teacher_id'])
                ->where('id', '<>', $id)
                ->where('status', '<>', CoursePlanStatus::Cancelled);
        } else {
            $resultsql = CoursePlan::query()
                ->where('teacher_id', $data['teacher_id'])
                ->where('status', '<>', CoursePlanStatus::Cancelled);
        }
        $this->ifDateTime($resultsql, $data['start_time'], $data['end_time']);
        $ifcoachstatus = $resultsql->first();
        if ($ifcoachstatus) {
            $msg = 'business.teacher has been course planed in this time';
            $error_data['teacher_name'] = Teacher::query()->where('id', $ifcoachstatus->teacher_id)->value('name');
            $error_data['course_name'] = Course::query()->where('id', $ifcoachstatus->course_id)->value('name');
            $error_data['time'] = $ifcoachstatus->start_at . '~' . $ifcoachstatus->end_at;

            $this->data[] = trans($msg, ['teacher_name' => $error_data['teacher_name'], 'course_name' => $error_data['course_name'], 'time' => $error_data['time']]);
            return $this->data;
        } else {
            return null;
        }
    }

    private function ifClassroomconflict($data, $id = 0)
    {
        if ($id) {
            $resultsql = CoursePlan::query()
                ->where('classroom_id', $data['classroom_id'])
                ->where('id', '<>', $id)
                ->where('status', '<>', CoursePlanStatus::Cancelled);
        } else {
            $resultsql = CoursePlan::query()
                ->where('classroom_id', $data['classroom_id'])
                ->where('status', '<>', CoursePlanStatus::Cancelled);
        }
        //判断月份的是否存在交集，存在就报提示错误
        $this->ifDateTime($resultsql, $data['start_time'], $data['end_time']);
        $ifclassroomconflict = $resultsql->first();
        if ($ifclassroomconflict) {
            $msg = 'business.The classroom time has been used';
            $error_data['course_name'] = Course::query()->where('id', $ifclassroomconflict->course_id)->value('name');
            $error_data['time'] = $ifclassroomconflict->start_at . '~' . $ifclassroomconflict->end_at;

            $this->data[] = trans($msg, ['course_name' => $error_data['course_name'], 'time' => $error_data['time']]);
            return $this->data;
        } else {
            return null;
        }
    }


    //判断时间是否存在交集
    private function ifDateTime($resultsql, $start_at, $end_at)
    {
        return $resultsql->where(function ($query) use ($start_at, $end_at) {
            $query->where(function ($query) use ($start_at, $end_at) {
                $query->where('start_at', '>=', $start_at)->where('start_at', '<=', $end_at);
            })->orWhere(function ($query) use ($start_at, $end_at) {
                $query->where('start_at', '<=', $start_at)->where('end_at', '>=', $end_at);
            })->orWhere(function ($query) use ($start_at, $end_at) {
                $query->where('end_at', '>=', $start_at)->where('end_at', '<=', $end_at);
            });
        });
    }

    //合并时间
    private function setDateTime(&$data, $date, $start_time, $end_time)
    {
        $data['start_time'] = $date . ' ' . $start_time;
        $data['end_time'] = $date . ' ' . $end_time;
    }
}
