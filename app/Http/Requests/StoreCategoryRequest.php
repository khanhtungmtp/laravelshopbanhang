<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreCategoryRequest extends FormRequest
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
     * ignore id, bỏ kiểm tra trùng với id hiện tại
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required|min:2|max:255|unique:categories,name,'.($this->id ?? '')
        ];
    }

    public function messages()
    {
        return [
            'unique' => ':attribute đã tồn tại',
            'required' => ':attribute không được bỏ trống',
            'min' => ':attribute phải từ 2-255 ký tự',
            'max' => ':attribute phải từ 2-255 ký tự'
        ];
    }

    public function attributes()
    {
        return [
            'name' => 'Tên danh mục sản phẩm'
        ];
    }
}
