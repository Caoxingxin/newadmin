<?php


namespace App\Http\Controllers\Head;


use App\Http\Controllers\Controller;
use App\Http\Models\Head\Student;
use App\Http\Requests\Head\HeadStudentRequest;
use App\Http\Services\School\HeadStudentServices;
use Illuminate\Http\Request;

class HeadStudentController extends Controller
{
    public function list(){
        $searchData = \Request::all();
        $page = $searchData['pageSize'] ?? 15;
        if (isset($searchData['searchStudentMobile']))
        {
            $SchoolData = Student::query()->where('mobile','like',$searchData['searchStudentMobile'].'%')->paginate($page);
        }else
        {
            $SchoolData = Student::query()->paginate($page);
        }
        return $SchoolData;
    }

    public function detail(Request $request,HeadStudentServices $services){
        $id = $request->input('id');
        return $services->detail($id);
    }

    public function update(HeadStudentRequest $request,HeadStudentServices $services){
        $data = $request->all();
        return $services->update($data);
    }
}
