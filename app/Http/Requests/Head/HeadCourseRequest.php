<?php

namespace App\Http\Requests\Head;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class HeadCourseRequest extends FormRequest
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
        $id = $this->input('id');
        if (!isset($id)){
            return [
                "name" =>  "required|unique:course,name,$id,id",
                "type" => "required",
                "duration" => "required",
                "remark" => "nullable|string",
            ];
        }else{
            return [
                "id" => "required|integer",
                "name" =>  "required|unique:course,name,$id,id",
                "type" => "required",
                "duration" => "required",
                "remark" => "nullable|string",
            ];
        }

    }

    protected function failedValidation(\Illuminate\Contracts\Validation\Validator $validator)
    {
        throw new HttpResponseException(response()->json(['msg'=>'error','code'=>'500','data'=>$validator->errors()], 500));
    }
}
