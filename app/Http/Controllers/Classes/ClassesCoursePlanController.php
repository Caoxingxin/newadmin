<?php


namespace App\Http\Controllers\Classes;


use App\Http\Controllers\Controller;
use App\Http\Models\Classes\CoursePlan;
use App\Http\Services\Head\SchoolCoursePlanServices;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ClassesCoursePlanController extends Controller
{
    public function list()
    {
        $searchData = \Request::all();
        $page = $searchData['pageSize'] ?? 15;
        $query = CoursePlan::query()
            ->leftJoin('class', 'class.id', '=', 'course_plan.class_id')
            ->leftJoin('course', 'course.id', '=', 'course_plan.course_id')
            ->leftJoin('teacher', 'teacher.id', '=', 'course_plan.teacher_id')
            ->leftJoin('classroom', 'classroom.id', '=', 'course_plan.classroom_id')
            ->where('classroom.school_id', '=', $searchData['school_id'])
            ->where('course_plan.class_id', $searchData['class_id']);
        if (isset($searchData['searchCourseName'])) {

            $query = $query->where('course.name', 'like', '%' . $searchData['searchCourseName'] . '%');

        }
        if (!empty($searchData['date'])) {

            $searchData['date']['end'] = date("Y-m-d", strtotime("+1 day", strtotime($searchData['date']['end'])));

            $query = $query->whereBetween('course_plan.start_at', $searchData['date']);
        }

        $couserplanData = $query->select('class.name as class_name', 'class.id as class_id',
            'course.name as course_name', 'course.id as course_id',
            'teacher.name as teacher_name', 'teacher.id as teacher_id',
            'classroom.name as classroom_name', 'classroom.id as classroom_id', 'course_plan.*')->orderByDesc('course_plan.start_at')->paginate($page);

        foreach ($couserplanData as $item){
            //用Carbon日期转换
            $item->date = Carbon::parse($item->start_at)->format('Y-m-d');
            $item->start_at = Carbon::parse($item->start_at)->format('H:i');
            $item->end_at = Carbon::parse($item->end_at)->format('H:i');
        }
        (int)$week = date('N', strtotime(date('Y-m-d')));
        $date = [];
        for ($i = 1; $i <= 7; $i++) {
            $date[$i] = date('Y-m-d', strtotime('+' . $i - $week . ' days', strtotime(date('Y-m-d'))));
        }
        $couserplanData = collect($couserplanData);
        $couserplanData->put('weekday',[$date]);


        return $couserplanData;
    }

    public function create(Request $request,SchoolCoursePlanServices $services)
    {
        $data = $request->all();
        return $services->create($data);
    }

    public function detail(Request $request,SchoolCoursePlanServices $services)
    {

        $id = $request->input('id');

        return $services->detail($id);
    }

    public function update(Request $request,SchoolCoursePlanServices $services)
    {
        $data = $request->all();
//        dd($data);
        return $services->update($data);
    }

    public function check(Request $request,SchoolCoursePlanServices $services)
    {

        $ids = $request->all();
        return $services->check($ids);
    }

    public function cancel(Request $request,SchoolCoursePlanServices $services)
    {

        $id = $request->all();
        return $services->cancel($id);
    }
}
