<?php


namespace App\Http\Controllers\School;


use App\Http\Controllers\Controller;
use App\Http\Models\School\Classes;
use App\Http\Models\School\StudentDistribute;
use App\Http\Requests\School\SchoolClassRequest;
use App\Http\Services\Head\SchoolClassServices;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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
        foreach ($ClessData as $item){
            $count = StudentDistribute::query()->where('class_id',$item['id'])->count('student_id');
            $item['count'] = $count;
        }
        return $ClessData;
    }

    public function create(SchoolClassRequest $request,SchoolClassServices $services){
        $data = $request->all();
        return $services->create($data);
    }

    public function update(SchoolClassRequest $request,SchoolClassServices $services){
        $data = $request->all();
        return $services->update($data);
    }

    public function detail(Request $request,SchoolClassServices $services){
        $id = $request->input('id');
        return $services->detail($id);
    }

    public function delete(Request $request,SchoolClassServices $services){
        $id = $request->input('id');
        return DB::transaction(function () use($id,$services){
            $services->delete($id);
        });
    }

    public function status(Request $request,SchoolClassServices $services){
        $status = $request->input('status');
        $id = $request->input('id');
        return $services->status($status,$id);
    }

}
