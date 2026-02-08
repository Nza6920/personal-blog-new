<?php

namespace App\Http\Controllers;

use App\Actions\Auth\LoginUser;
use App\Actions\Auth\LogoutUser;
use App\Http\Requests\SessionRequest;

class SessionsController extends Controller
{
    public function show()
    {
        return view('sessions.login');
    }

    public function store(SessionRequest $request, LoginUser $loginUser)
    {
        $credentials = [
            'email' => $request->username,
            'password' => $request->password,
        ];

        if (! $loginUser->handle($credentials)) {
            session()->flash('danger', '抱歉，邮箱或密码不匹配。');

            return redirect()->back();
        }

        return redirect()->route('admin.show');
    }

    public function destroy(LogoutUser $logoutUser)
    {
        $logoutUser->handle();
        session()->flash('success', '您已成功退出！');

        return redirect('admin');
    }
}
