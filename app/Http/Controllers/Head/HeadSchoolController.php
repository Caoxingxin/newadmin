<?php


namespace App\Http\Controllers\Head;


use App\Http\Controllers\Controller;
use App\Http\Models\Head\School;

class HeadSchoolController extends Controller
{
    public function school_list(){
        $SchoolData = School::query()->get();
        return $SchoolData->toArray();
    }
    public function index(){
        dd('后台首页，当前管理员：' . auth('admin')->user()->name);
    }
}
