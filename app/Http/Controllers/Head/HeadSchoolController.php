<?php


namespace App\Http\Controllers\Head;


use App\Http\Controllers\Controller;
use App\Http\Models\Head\School;
use App\Http\Requests\Head\HeadSchoolCreateRquest;
use App\Http\Requests\Head\HeadSchoolUpdateRquest;
use App\Http\Services\School\HeadSchoolServices;
use Illuminate\Http\Request;

class HeadSchoolController extends Controller
{
    public function school_list(){
        $searchData = \Request::all();
        $page = $searchData['pageSize'] ?? 15;
        if (isset($searchData['searchSchoolName']))
        {
            $SchoolData = School::query()->where('name','like','%'.$searchData['searchSchoolName'].'%')->paginate($page);
        }else
        {
            $SchoolData = School::query()->paginate($page);
        }
        return $SchoolData;
    }
    //改变状态
    public function school_status(Request $request,HeadSchoolServices $services){
        $status = $request->input('status');
        $id = $request->input('id');
        return $services->status($status,$id);
    }
    //创建学校
    public function create(HeadSchoolCreateRquest $request,HeadSchoolServices $services){
        $data = $request->all();
        return $services->create($data);
    }
    //学校详情
    public function detail(Request $request,HeadSchoolServices $services){
        $id = $request->input('id');
        return $services->detail($id);
    }
    //更新学校
    public function update(HeadSchoolUpdateRquest $request,HeadSchoolServices $services){
        $data = $request->all();
        return $services->update($data);
    }
    public function index(){
        dd('后台首页，当前管理员：' . auth('admin')->user()->name);
    }
}
