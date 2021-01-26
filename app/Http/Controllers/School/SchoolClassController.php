<?php


namespace App\Http\Controllers\School;


use App\Http\Controllers\Controller;
use App\Http\Models\School\Classes;
use App\Http\Services\Head\SchoolClassServices;
use Illuminate\Http\Request;

class SchoolClassController extends Controller
{
    public function list(){
        $searchData = \Request::all();
        $page = $searchData['pageSize'] ?? 15;
        if (isset($searchData['searchClassName']))
        {
            $ClessData = Classes::query()
                ->leftJoin('school','class.school_id','=','school.id')
                ->leftJoin('semester','class.semester_id','=','semester.id')
                ->where('class.school_id',$searchData['school_id'])
                ->where('class.name','like','%'.$searchData['searchClassName'].'%')
                ->select('class.*','school.name as school_name','semester.name as semester_name')
                ->paginate($page);
        }else
        {
            $ClessData = Classes::query()
                ->leftJoin('school','class.school_id','=','school.id')
                ->leftJoin('semester','class.semester_id','=','semester.id')
                ->where('class.school_id',$searchData['school_id'])
                ->select('class.*','school.name as school_name','semester.name as semester_name')
                ->paginate($page);
        }

        return $ClessData;
    }

    public function create(){

    }

    public function update(){

    }

    public function detail(Request $request,SchoolClassServices $services){
        $id = $request->input('id');
        return $services->detail($id);
    }

    public function delete(){

    }

    public function status(){

    }

}
