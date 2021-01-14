<?php


namespace App\Http\Controllers\Head;


use App\Http\Controllers\Controller;
use App\Http\Models\Head\Course;
use App\Http\Requests\Head\HeadCourseRequest;
use App\Http\Services\School\HeadCourseServices;
use Illuminate\Http\Request;

class HeadCourseController extends Controller
{
    public function list(){
        $searchData = \Request::all();
        $page = $searchData['pageSize'] ?? 15;
        if (isset($searchData['searchCourseName']))
        {
            $SchoolData = Course::query()->where('name','like','%'.$searchData['searchCourseName'].'%')->paginate($page);
        }else
        {
            $SchoolData = Course::query()->paginate($page);
        }
        return $SchoolData;
    }

    public function detail(Request $request,HeadCourseServices $services){
        $id = $request->input('id');
        return $services->detail($id);
    }

    public function create(HeadCourseRequest $request,HeadCourseServices $services){
        $data = $request->all();
        return $services->create($data);
    }

    public function update(HeadCourseRequest $request,HeadCourseServices $services){
        $data = $request->all();
        return $services->update($data);
    }

    public function status(Request $request,HeadCourseServices $services){
        $status = $request->input('status');
        $id = $request->input('id');
        return $services->status($status,$id);
    }
    public function delete(Request $request,HeadCourseServices $services){
        $id = $request->input('id');
        return $services->delete($id);
    }
}
