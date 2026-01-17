<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Http\Requests\SessionRequest;


class SessionsController extends Controller
{
    public function show()
    {
        return view('sessions.login');
    }

    public function store(SessionRequest $request)
    {
        $credentials = [
          'email' => $request->username,
          'password' => $request->password,
        ];

        if (!Auth::attempt($credentials)) {
          session()->flash('danger', '很抱歉，您的邮箱和密码不匹配.');
          return redirect()->back();
        }

        return redirect()->route('admin.show');
    }

    public function destroy()
    {
      Auth::logout();
      session()->flash('success', '您已成功退出！');
      return redirect('admin');
    }
}
