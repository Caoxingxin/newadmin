<?php


namespace App\Http\Controllers\School;


use App\Http\Constans\School\SemesterStatus;
use App\Http\Controllers\Controller;
use App\Http\Models\School\Semester;
use App\Http\Requests\School\SchoolSemesterRequest;
use App\Http\Services\Head\SchoolSemesterServices;
use Illuminate\Http\Request;

class SchoolSemesterController extends Controller
{
    public function list(){
        $searchData = \Request::all();
        $page = $searchData['pageSize'] ?? 15;
        if (isset($searchData['searchSemesterName']))
        {
            $SemesterData = Semester::query()
                ->where('school_id',$searchData['school_id'])
                ->where('name','like','%'.$searchData['searchSemesterName'].'%')->paginate($page);
        }else
        {
            $SemesterData = Semester::query()
                ->where('school_id',$searchData['school_id'])
                ->paginate($page);
        }
        return $SemesterData;
    }

    public function create(SchoolSemesterRequest $request,SchoolSemesterServices $services){
        $data = $request->all();
        return $services->create($data);
    }

    public function update(SchoolSemesterRequest $request,SchoolSemesterServices $services){
        $data = $request->all();
        return $services->update($data);
    }

    public function status(Request $request,SchoolSemesterServices $services){
        $status = $request->input('status');
        $id = $request->input('id');
        return $services->status($status,$id);
    }

    public function detail(Request $request,SchoolSemesterServices $services){
        $id = $request->input('id');
        return $services->detail($id);
    }

    public function delete(Request $request,SchoolSemesterServices $services){
        $id = $request->input('id');
        return $services->delete($id);
    }

    public function getList(Request $request){
        $school_id = $request->input('school_id');
        return Semester::query()->where('school_id',$school_id)->where('status',SemesterStatus::ONLINE)->get();
    }
}
