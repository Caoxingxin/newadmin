<?php

namespace App\Http\Requests\School;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class SchoolSemesterRequest extends FormRequest
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
            return[
                'name' => "required|unique:semester,name,$id,id,school_id,$school_id|alpha_dash|between:2,200",
                'start_date' => 'required|date',
                'end_date' => 'required|date',
                //验证电话号带座机验证
                'contact' => ['size:11','required', function ($attribute, $value, $fail) {
                    $this->validateContact($value, $fail);
                }],
                'register_start_at' => 'required|date',
                'register_end_at' => 'required|date',
                'number' => 'required|numeric',
                'tuition' => 'required|numeric|min:0.01',
            ];
        }else{
            return[
                'id' => 'required',
                'name' => "required|unique:semester,name,$id,id,school_id,$school_id|alpha_dash|between:2,200",
                'start_date' => 'required|date',
                'end_date' => 'required|date',
                //验证电话号带座机验证
                'contact' => ['size:11','required', function ($attribute, $value, $fail) {
                    $this->validateContact($value, $fail);
                }],
                'register_start_at' => 'required|date',
                'register_end_at' => 'required|date',
                'number' => 'required|numeric',
                'tuition' => 'required|numeric|min:0.01',
            ];
        }

    }

    private function validateContact($value, $fail)
    {
        /* 验证输入的联系方式是否为全为数字 */
        if (!preg_match('/^[0-9]*$/', $value)) {
            return $fail(trans('invalid.contact.number', ['error' => $value]));
        }
        switch ($value[0]) {
            case '0':   // 0开头为带区号固定电话，暂无特殊验证
                break;
            case '1':
                $reg_mobile = '/^1[3-9]\d{9}$/';    // 匹配以1开头，第二位为3~9的号码，全长11位
                if (!preg_match($reg_mobile, $value)) {
                    return $fail(trans('validation.mobile.invalid', ['error' => substr($value, 0, 2)]));
                }
                break;
            default:
                return $fail(trans('invalid.contact.number', ['error' => $value]));
                break;
        }
    }

    protected function failedValidation(\Illuminate\Contracts\Validation\Validator $validator)
    {
        throw new HttpResponseException(response()->json(['msg'=>'error','code'=>'500','data'=>$validator->errors()], 500));
    }
}
