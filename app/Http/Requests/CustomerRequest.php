<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CustomerRequest extends FormRequest
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
        return [
            'email' => 'required|email',
            'phone' => 'required|numeric',
            'address' => 'required|min:4|max:255'
        ];
    }

    public function messages()
    {
        return [
            'required' => ':attribute không được bỏ trống',
            'email' => ':attribute phải là email hợp lệ',
            'numeric' => ':attribute phải là số',
            'max' => ':attribute phải từ 4 đến 255 ký tự',
            'min' => ':attribute phải từ 4 đến 255 ký tự',
        ];
    }

    public function attributes()
    {
        return [
            'email' => 'Email',
            'phone' => 'Số điện thoại',
            'address' => 'Địa chỉ nhận hàng',
        ];
    }
}
