<?php


namespace App\Http\Controllers\Index;


use App\Http\Controllers\Controller;
use App\Http\Models\Head\School;
use App\Http\Models\Head\Student;
use App\Http\Models\Head\Teacher;
use App\Http\Models\School\Order;
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

}
