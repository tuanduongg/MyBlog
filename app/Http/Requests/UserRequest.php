<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
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
            'name' => 'required',
            'password' => 'required',
            'role' => 'required',
            'email' => 'required|unique:users',
            // 'avatar' => 'image|mimes:jpeg,png,jpg,gif|max:2048',

        ];
    }
    public function messages()
    {
        return [
            'email.required' => 'Email bắt buộc điền!',
            'email.unique' => 'Email đã tồn tại!',
            'name.required' => 'Họ Tên bắt buộc phải điền!',
            'password.required' => 'Mật Khẩu bắt buộc phải điền!',
            'role.required' => 'Bắt buộc phải chọn Quyền!',
            // 'avatar.image' => 'Không đúng định dạng file ảnh!',
            // 'avatar.mimes' => 'File quá lớn!',
        ];
    }
}
