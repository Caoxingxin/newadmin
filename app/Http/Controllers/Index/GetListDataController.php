<?php


namespace App\Http\Controllers\Index;


use App\Http\Controllers\Controller;
use App\Http\Models\Head\School;
use App\Http\Models\Head\Student;
use App\Http\Models\Head\Teacher;
use App\Http\Models\School\Order;
use App\Http\Models\School\Student_School;
use Illuminate\Http\Request;

class GetListDataController extends Controller
{
    public function getSchoolList()
    {
        return School::query()->get();
    }

    public function getStudentList()
    {
        return Student::query()->get();
    }

    public function getOrderList()
    {
        return Order::query()->orderByDesc('created_at')->get();

    }

    public function getTeacherList(){
        return Teacher::query()->orderByDesc('full_time')->get();
    }

    public function getSchoolNum(){
        return Student_School::query()->selectRaw('school.name as name,school_id,count(school_id) as number')
            ->leftJoin('school','school.id','student_school.school_id')
            ->groupBy('school_id')->get();
    }

}
