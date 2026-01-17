<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>Niu的个人博客 - 后台登录</title>
<link rel="stylesheet" href="http://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.1.0/css/font-awesome.min.css">
<link rel='stylesheet' href='/css/jquery-ui.css'>
<link rel='stylesheet prefetch' href='/css/bootstrap.min.css'>
<link rel="stylesheet" href="/css/style.css" media="screen" type="text/css" />
<link rel="icon" href="{{asset('uploads/images/system/niu.png')}}" type="image/x-icon">
<script src="/js/modernizr.js"></script>
</head>
<body class="login-page">
  @include('error.error')
  @include('layouts._message')
<div class="login-form">
    <div class="login-content">
        <form method="post" action="{{ route('login') }}" id="form_login">
          {{ csrf_field() }}
            <div class="form-group">
                <div class="input-group">
                    <div class="input-group-addon"> <i class="fa fa-user"></i> </div>
                    <input type="text" class="form-control" name="username" id="username" placeholder="Username" autocomplete="off" />
                </div>
            </div>
            <div class="form-group">
                <div class="input-group">
                    <div class="input-group-addon"> <i class="fa fa-key"></i> </div>
                    <input type="password" class="form-control" name="password" id="password" placeholder="Password" autocomplete="off" />
                </div>
            </div>
            <div class="form-group">
                <button type="submit" class="btn btn-primary btn-block btn-login"> <i class="fa fa-sign-in"></i> Login in </button>
            </div>
        </form>
    </div>
</div>
</div>
</body>
</html>
