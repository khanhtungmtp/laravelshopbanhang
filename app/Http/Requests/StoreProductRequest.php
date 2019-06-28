<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreProductRequest extends FormRequest
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
     * ignore id, ko kiểm tra trùng với id hiện tại
     * ignore image, ko kiểm tra bắt buộc up hình với id hiện tại
     * @return array
     */
    public function rules()
    {
        return [
            'name'        => 'required|string|min:2|max:50|unique:products,name,'.($this->id ?? ''),
            'image'       => ($this->id ? 'nullable' : 'required').'|image|mimes:jpeg,jpg,png,gif',
            'price'       => 'required|numeric',
            'quantity'    => 'required|numeric',
            'promotional' => 'required|numeric'
        ];
    }

    public function messages()
    {
        return [
            'required' => ':attribute là trường bắt buộc ',
            'string'   => ':attribute phải là dạng chuỗi',
            'image'    => ':attribute chỉ hỗ trợ các đuôi png, jpeg, gif, jpg',
            'min'      => ':attribute phải từ 2-50 ký tự',
            'max'      => ':attribute phải từ 2-50 ký tự',
            'unique'   => ':attribute đã tồn tại',
            'mimes'    => ':attribute có đuôi không được hỗ trợ',
            'numeric'  => ':attribute phải là số',
        ];
    }

    public function attributes()
    {
        return [
            'name'        => 'Tên sản phẩm',
            'image'       => 'Hình ảnh',
            'price'       => 'Giá',
            'quantity'    => 'Số lượng',
            'promotional' => 'Giá khuyến mãi'
        ];
    }
}
