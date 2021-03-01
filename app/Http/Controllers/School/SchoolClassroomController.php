<?php


namespace App\Http\Controllers\School;


use App\Http\Controllers\Controller;
use App\Http\Models\Head\School;
use App\Http\Models\School\Classroom;
use App\Http\Requests\School\SchoolClassroomRequest;
use App\Http\Services\Head\SchoolClassroomServices;
use Illuminate\Http\Request;

class SchoolClassroomController extends Controller
{
    public function list(){
        $searchData = \Request::all();
        $page = $searchData['pageSize'] ?? 15;
        if (isset($searchData['searchClassroomName']))
        {
            $ClassroomData = Classroom::query()
                ->leftJoin('school','classroom.school_id','=','school.id')
                ->where('school_id',$searchData['school_id'])
                ->where('classroom.name','like','%'.$searchData['searchClassroomName'].'%')
                ->select('classroom.*','school.name as school_name')
                ->paginate($page);
        }else
        {
            $ClassroomData = Classroom::query()
                ->leftJoin('school','classroom.school_id','=','school.id')
                ->where('school_id',$searchData['school_id'])
                ->select('classroom.*','school.name as school_name')
                ->paginate($page);
        }

        return $ClassroomData;
    }

    public function create(SchoolClassroomRequest $request,SchoolClassroomServices $services){
        $data = $request->all();
        return $services->create($data);
    }

    public function update(SchoolClassroomRequest $request,SchoolClassroomServices $services){
        $data = $request->all();
        return $services->update($data);
    }

    public function detail(Request $request,SchoolClassroomServices $services){
        $id = $request->input('id');
        return $services->detail($id);
    }

    public function status(Request $request,SchoolClassroomServices $services){
        $status = $request->input('status');
        $id = $request->input('id');
        return $services->status($status,$id);
    }

    public function delete(Request $request,SchoolClassroomServices $services){
        $id = $request->input('id');
        return $services->delete($id);
    }

    public function getList(Request $request){
        $school_id = $request->input('school_id');
        return Classroom::query()->where('school_id',$school_id)->get();
    }
}
