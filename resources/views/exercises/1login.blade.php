@extends('layouts.login-app')

@section('content')

<section class="content">
        <h3 class="logo" ><img  src="{{asset('assets/images/logo.png')}}" alt="logo" width="170"></h3>

        <div class="text-content">
            <h2 class="head-text">Kirish</h2>
            <p class="body-text">Tizimga kirish uchun
                email & parolingizni kiriting!</p>
        </div>
    </section>
    <div class="login">
        <div class="form-body">
            <form method="POST" action="{{ route('login') }}">
                @csrf
                <div class="form-head">
                    <h3><a href="#" class="logo-link"><img src="{{asset('assets/images/logo.png')}}" alt="logo" width="48"></a> <span class="logo-text">ga xush kelibsiz</span>
                    </h3>
                </div>
                <div class="float-left">
                    <h3 class="begin">Kirish</h3>
                </div>
{{--                <div class="float-right">--}}
{{--                <p>Hisobingiz yo’qmi ?</p>--}}
{{--                <a href="{{ route('register') }} ">Ro’yxatdan o’tish</a>--}}
{{--                </div>--}}
        </div>
        <div class="margin-top"></div>
        <div class="form-group">
            <label for="">Login kiriting</label>
            <!-- <input type="email" placeholder="Email" name="email"> -->
            <input id="email" type="text" class="@error('email') is-invalid @enderror" name="login"
                value="{{ old('login') }}" required autocomplete="email" autofocus placeholder="Login">
            @error('login')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>

        <div class="form-group">
            <label for="">Parolni kiriting</label>
            <input id="password" type="password" class=" @error('password') is-invalid @enderror" name="password"
                required autocomplete="current-password">

            @error('password')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror

        </div>
        <div class="form-group">

            <span class="remebber">
                @if (Route::has('password.request'))
                <a class="btn btn-link" href="{{ route('password.request') }}">
{{--                    Parolni unitdingizmi?--}}
                </a>
                @endif
            </span>
        </div>

        <div class="form-group">
            <button class="login-button">Kirish</button>
        </div>
        </form>
    </div>
    <section class="bottom-content"></section>
</section>

@endsection
