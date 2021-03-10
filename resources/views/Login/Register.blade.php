<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>轻音教育后台管理</title>

    <!-- Scripts -->

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="http://www.jq22.com/jquery/font-awesome.4.6.0.css">


    <!-- Styles -->
    <link href="{{asset('css/login.css')}}" rel="stylesheet">
    <style>
        html, body {
            background-color: #fff;
            color: #636b6f;
            font-family: 'Nunito', sans-serif;
            font-weight: 200;
            height: 100vh;
            margin: 0;
        }

        .full-height {
            height: 100vh;
        }

        .position-ref {
            position: relative;
        }

        .top-right {
            position: absolute;
            right: 10px;
            top: 18px;
        }

        .content {
            text-align: center;
            margin-top: 50px;
        }

        .links > a {
            color: #636b6f;
            padding: 0 25px;
            font-size: 13px;
            font-weight: 600;
            letter-spacing: .1rem;
            text-decoration: none;
            text-transform: uppercase;
        }

    </style>
</head>
<body id="app">
<div class="flex-center position-ref full-height">
    <div class="content">
        <div class="pen-title">
            <h1>轻音教育后台管理系统</h1>
        </div>
        <div class="container">

            <div class="card o-hidden border-0 shadow-lg my-5">
                <div class="card-body p-0">
                    <!-- Nested Row within Card Body -->
                    <div class="row">
                        <div class="col-lg-5 d-none d-lg-block bg-register-image"></div>
                        <div class="col-lg-7">
                            <div class="p-5">
                                <div class="text-center">
                                    <h1 class="h4 text-gray-900 mb-4">创建一个账户!</h1>
                                </div>
                                <form class="user" method="POST" action="{{ route('admin.register') }}">
                                    @csrf
                                    <div class="form-group">
                                        <input id="exampleFirstName" type="text"
                                               class="form-control form-control-user @error('name') is-invalid @enderror"
                                               name="name"
                                               value="{{ old('name') }}" placeholder="账户名称" required
                                               autocomplete="name" autofocus>
                                        @error('name')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <input id="exampleInputEmail" type="email"
                                               class="form-control form-control-user @error('email') is-invalid @enderror"
                                               name="email"
                                               value="{{ old('email') }}" placeholder="账户邮箱地址" required
                                               autocomplete="email">
                                        @error('email')
                                        <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                        @enderror
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-sm-6 mb-3 mb-sm-0">
                                            <input id="exampleInputPassword" type="password"
                                                   class="form-control form-control-user @error('password') is-invalid @enderror"
                                                   name="password" placeholder="Password" required
                                                   autocomplete="new-password">
                                            @error('password')
                                            <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror
                                        </div>
                                        <div class="col-sm-6">
                                            <input id="exampleRepeatPassword" type="password" class="form-control form-control-user"
                                                   name="password_confirmation" placeholder="Repeat Password" required autocomplete="new-password">
                                        </div>
                                    </div>
                                    <button type="submit" class="btn btn-primary btn-user btn-block">
                                        {{ __('注册') }}
                                    </button>
                                </form>
                                <hr>
                                <div class="text-center">
                                    <a class="small" href="{{ url('admin/login') }}">{{ __('已经有一个账户了？立即登录！') }}</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
