<?php

namespace App\Http\Requests;


class SessionRequest extends Request
{
    public function rules()
    {
        return [
            'username' => ['required','max:20'],
            'password' => ['required','max:16'],
        ];
    }

    public function messages()
    {
        return [
            'username.required' => '用戶名不能为空',
            'password.required'  => '密码不能为空',
            'username.max' => '用戶名格式错误',
            'password.max'  => '密码格式错误'
        ];
    }
}
