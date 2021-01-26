<?php

namespace App\Http\Requests\School;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class SchoolClassroomRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $school_id = $this->input('school_id');
        $id = $this->input('id');
        if (!isset($id)){
            $id = null;
            return [
                'name' => "required|unique:classroom,name,$id,id,school_id,$school_id|alpha_dash|between:2,200",
                'max_number' => 'required|numeric',
            ];
        }else{
            return [
                'id' => "required",
                'name' => "required|unique:classroom,name,$id,id,school_id,$school_id|alpha_dash|between:2,200",
                'max_number' => 'required|numeric',
            ];
        }
    }

    protected function failedValidation(\Illuminate\Contracts\Validation\Validator $validator)
    {
        throw new HttpResponseException(response()->json(['msg'=>'error','code'=>'500','data'=>$validator->errors()], 500));
    }
}
