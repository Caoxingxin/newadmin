<?php


namespace App\Http\Controllers\Head;


use App\Http\Controllers\Controller;
use App\Http\Models\Head\Teacher;
use App\Http\Requests\Head\HeadTeacherRequest;
use App\Http\Services\School\HeadTeacherServices;
use Illuminate\Http\Request;

class HeadTeacherController extends Controller
{
    public function list(){
        $searchData = \Request::all();
        $page = $searchData['pageSize'] ?? 15;
        if (isset($searchData['searchTeacherMobile']))
        {
            $SchoolData = Teacher::query()->where('mobile','like',$searchData['searchTeacherMobile'].'%')->paginate($page);
        }else
        {
            $SchoolData = Teacher::query()->paginate($page);
        }
        return $SchoolData;
    }

    public function detail(Request $request,HeadTeacherServices $services){
        $id = $request->input('id');
        return $services->detail($id);
    }

    public function create(HeadTeacherRequest $request,HeadTeacherServices $services){
        $data = $request->all();
        $data['entry_time'] = date('Y-m-d',strtotime($data['entry_time']));
        if ($data['full_time']){
            $data['full_time'] = date('Y-m-d',strtotime($data['full_time']));
        }
        return $services->create($data);
    }

    public function update(HeadTeacherRequest $request,HeadTeacherServices $services){
        $data = $request->all();
        return $services->update($data);
    }

    public function delete(Request $request,HeadTeacherServices $services){
        $id = $request->input('id');
        return $services->delete($id);
    }

    public function status(Request $request,HeadTeacherServices $services){
        $status = $request->input('status');
        $id = $request->input('id');
        $full_time = $request->input('full_time');
        $full_time = date('Y-m-d',strtotime($full_time));
        //dd($status,$id,$full_time);
        return $services->status($status,$id,$full_time);
    }

    public function getList(){
        return Teacher::query()->get();
    }

}
