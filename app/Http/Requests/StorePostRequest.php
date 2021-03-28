<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StorePostRequest extends FormRequest
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
            'title' => [
                'required',
                'min:4',
                Rule::unique('posts')->ignore($this->id)
            ],
            'image' => 'image',
            'cate_id'=> 'required',
            'content'=>['required','min:10'],
            'short_desc'=>['required','min:10'],
            'author'=>['required','min:2'],
        ];
    }

    public function messages()
    {
        return [
            'title.required' => "Hãy nhập tên bài viết",
            'title.min' => "Ít nhất có 4 ký tự",
            'title.unique' => "Tên bài viết đã tồn tại",
            'image.image' => "Hãy chọn file ảnh",
            'cate_id.required' => "Hãy chọn danh mục",
            'content.required' => "Hãy nhập nội dung",
            'content.min' => "Nội dung quá ngắn",
            'short_desc.required' => "Hãy nhập mô tả",
            'short_desc.min' => "Mô tả quá ngắn",
            'author.required' => "Hãy nhập tên tác giả",
            'author.min' => "Ít nhất có 2 ký tự",
        ];
    }
}