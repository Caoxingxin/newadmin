<?php

namespace App\Http\Requests\Head;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class HeadTeacherRequest extends FormRequest
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
                "name" => "required|regex:/^[\s*A-Za-z\x80-\xff]{2,30}$/",
                "mobile" => [
                    "required",
                    "max:11",
                    "unique:teacher,mobile,$id,id",
                    function ($attribute, $value, $fail) {
                        $this->validateContact($value, $fail);
                    }
                ],
                "email" => "nullable|string|regex:/\w+([-+.]\w+)*@\w+([-.]\w+)*\.\w+([-.]\w+)*/",
                'gender' => 'required',
                'address' => 'required',
                'entry_time' => 'required',
                'status' => 'required',
            ];
        }else{
            return [
                "id" => "required",
                "name" => "required|regex:/^[\s*A-Za-z\x80-\xff]{2,30}$/",
                "mobile" => [
                    "required",
                    "max:11",
                    "unique:teacher,mobile,$id,id",
                    function ($attribute, $value, $fail) {
                        $this->validateContact($value, $fail);
                    }
                ],
                "email" => "nullable|string|regex:/\w+([-+.]\w+)*@\w+([-.]\w+)*\.\w+([-.]\w+)*/",
                'gender' => 'required',
                'address' => 'required',
                'entry_time' => 'required',
                'full_time' => 'required_if:status,20',
                'status' => 'required|in:10,20',
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
