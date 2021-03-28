<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class StoreUserRequest extends FormRequest
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
            'name' => ['required','min:4'],
            'email' => [
                'required',
                'email',
                Rule::unique('users')->ignore($this->id)
            ],
            'role'=>'required',
            'password'=> ['required','min:6'],
            'avatar' => 'image'
        ];
    }

    public function messages()
    {
        return [
            'name.required' => "Hãy nhập tên danh mục",
            'name.min' => "Ít nhất có 4 ký tự",
            'email.required' => 'Vui lòng nhập email',
            'email.email' => 'Email không đúng định dạng',
            'email.unique' => "Email đã tồn tại",
            'role.required' => "Hãy chọn vai trò",
            'password.required' => 'Vui lòng nhập password',
            'password.min' => 'Password ít nhất có 6 ký tự',
            'avatar.image' => "Hãy chọn file ảnh",
        ];
    }
}