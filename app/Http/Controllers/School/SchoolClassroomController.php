<?php


namespace App\Http\Controllers\School;


use App\Http\Controllers\Controller;
use App\Http\Models\Head\School;
use App\Http\Models\School\Classroom;

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

    public function create(){

    }

    public function update(){

    }

    public function detail(){

    }

    public function status(){

    }

    public function delete(){

    }

}
