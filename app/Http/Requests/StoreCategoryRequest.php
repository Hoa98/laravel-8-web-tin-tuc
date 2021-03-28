<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

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
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => [
                'required',
                'min:2',
                Rule::unique('categories')->ignore($this->id)
            ],
            'logo' => 'image'
        ];
    }

    public function messages()
    {
        return [
            'name.required' => "Hãy nhập tên danh mục",
            'name.min' => "Ít nhất có 2 ký tự",
            'name.unique' => "Tên danh mục đã tồn tại",
            'logo.image' => "Hãy chọn file ảnh",
        ];
    }
}