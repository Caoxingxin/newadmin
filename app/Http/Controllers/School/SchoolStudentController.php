<?php


namespace App\Http\Controllers\School;


use App\Http\Controllers\Controller;
use App\Http\Models\Head\Student;
use App\Http\Models\School\Student_School;
use App\Http\Requests\School\SchoolStudentRequest;
use App\Http\Services\School\HeadStudentServices;
use Illuminate\Http\Request;

class SchoolStudentController extends Controller
{
    public function list()
    {
        $searchData = \Request::all();
        $page = $searchData['pageSize'] ?? 15;
        $query = Student_School::query()->where('school_id', $searchData['school_id'])->pluck('student_id')->toArray();

        if ($query) {
            if (isset($searchData['searchStudentMobile'])) {

                $StudentData = Student::query()
                    ->whereIn('id', $query)
                    ->where('mobile', 'like', $searchData['searchStudentMobile'] . '%')
                    ->paginate($page);
            }else{
                $StudentData = Student::query()
                    ->whereIn('id', $query)
                    ->paginate($page);
            }
        }else{
            $StudentData = ['current_page'=>1,'data'=>null];
        }

        return $StudentData;
    }

    public function create(SchoolStudentRequest $request,HeadStudentServices $services)
    {
        $data = $request->all();
        return $services->create($data);
    }

    public function update(SchoolStudentRequest $request,HeadStudentServices $services)
    {
        $data = $request->all();
        return $services->update($data);
    }

    public function detail(Request $request,HeadStudentServices $services)
    {
        $id = $request->input('id');
        return $services->detail($id);
    }
}
