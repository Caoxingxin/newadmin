<?php

namespace App\Http\Requests\Head;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\ValidationException;
use Illuminate\Validation\Validator;

class HeadSchoolCreateRquest extends FormRequest
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
    public function rules($id =null)
    {
        return [
            'name' => "required|unique:school,name,$id,id|alpha_dash|between:2,200",
            'picture' => 'required',
            'phone' => ['required', 'size:11', function ($attribute, $value, $fail) {
                $this->validateContact($value, $fail);
            }],
            'email' => 'nullable|email',
            'address' => 'required|alpha_dash',
        ];
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
