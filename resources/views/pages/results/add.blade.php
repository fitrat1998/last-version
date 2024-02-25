@extends('layouts.admin')

@section('content')

    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Talaba</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}">Bo'sh sahifa</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('userIndex') }}">Talabalar</a></li>
                        <li class="breadcrumb-item active">Qo'shish</li>
                    </ol>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>
    <!-- Main content -->

    <section class="content">
        <div class="row">
            <div class="col-lg-8 offset-lg-2 col-sm-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Qo'shish</h3>
                        @if(session('success'))
                            <div class="alert alert-success">
                                {{ session('success') }}
                            </div>
                        @endif
                        <div class="float-right">
                            <form action="{{ route('studentImport') }}" method="post" enctype="multipart/form-data">
                                @csrf
                                <input type="file" name="excel"
                                       accept=".csv, application/vnd.openxmlformats-officedocument.spreadsheetml.sheet, application/vnd.ms-excel"
                                       class="form float-left{{ $errors->has('photo') ? "is-invalid":"" }}"
                                       value="{{ old('excel') }}">
                                @if($errors->has('excel'))
                                    <span class="error invalid-feedback">{{ $errors->first('photo') }}</span>
                                @endif
                                <button type="submit" class="btn btn-success float-right">Yuklash</button>


                            </form>
                        </div>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">

                        <form action="{{ route('studentCreate') }}" method="post" enctype="multipart/form-data">
                            @csrf
                            <div class="form-group">
                                <label>Fish</label>
                                <input type="text" name="fullname"
                                       class="form-control {{ $errors->has('firstname') ? "is-invalid":"" }}"
                                       value="{{ old('fullname') }}" required>
                                @if($errors->has('name'))
                                    <span class="error invalid-feedback">{{ $errors->first('name') }}</span>
                                @endif
                            </div>

                            <div class="form-group">
                                <label>Rasm</label>
                                <input type="file" name="photo" accept="image/png, image/gif, image/jpeg"
                                       class="form-control {{ $errors->has('photo') ? "is-invalid":"" }}"
                                       value="{{ old('photo') }}">
                                @if($errors->has('photo'))
                                    <span class="error invalid-feedback">{{ $errors->first('photo') }}</span>
                                @endif
                            </div>
                            <div class="form-group">
                                <label>Yo'nalish</label><br/>
                                <select class="form-control " name="programm_id" id="programm_id">
                                    <option value="">yo'nalishni tanlang</option>
                                    @foreach($programms as $programm)
                                        <option value="{{ $programm->id }}">{{ $programm->programm_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Email</label>
                                <input type="email" name="email"
                                       class="form-control {{ $errors->has('email') ? "is-invalid":"" }}"
                                       value="{{ old('email') }}">
                                @if($errors->has('name'))
                                    <span class="error invalid-feedback">{{ $errors->first('name') }}</span>
                                @endif
                            </div>

                            <div class="form-group">
                                <label>Telefon raqam</label>
                                <input type="text" name="phone"
                                       class="form-control {{ $errors->has('phone') ? "is-invalid":"" }}"
                                       value="{{ old('phone') }}" required>
                                @if($errors->has('name'))
                                    <span class="error invalid-feedback">{{ $errors->first('name') }}</span>
                                @endif
                            </div>

                            <div class="form-group">
                                <label>Login</label>
                                <input type="text" name="login"
                                       class="form-control {{ $errors->has('login') ? "is-invalid":"" }}"
                                       value="{{ old('login') }}" required>
                                @if($errors->has('name'))
                                    <span class="error invalid-feedback">{{ $errors->first('name') }}</span>
                                @endif
                            </div>


                            <div class="form-group">
                                <label>Parol</label>
                                <input type="password" name="password" id="password-field"
                                       class="form-control {{ $errors->has('password') ? "is-invalid":"" }}" required>
                                <button toggle="#password-field"
                                      class="fa fa-fw fa-eye toggle-password field-icon"></button>
                                @if($errors->has('password'))
                                    <span class="error invalid-feedback">{{ $errors->first('password') }}</span>
                                @endif
                            </div>
                            <div class="form-group">
                                <label>parolni tasdiqlash</label>
                                <input id="password-confirm" type="password" class="form-control"
                                       name="password_confirmation" required autocomplete="new-password">
                                <span toggle="#password-confirm"
                                      class="fa fa-fw fa-eye toggle-password field-icon"></span>
                                @if($errors->has('password_confirmation'))
                                    <span
                                        class="error invalid-feedback">{{ $errors->first('password_confirmation') }}</span>
                                @endif
                            </div>
                            <div class="form-group">
                                <button type="submit" class="btn btn-success float-right">Saqlash</button>
                                <a href="{{ route('studentIndex') }}" class="btn btn-default float-left">Bekor
                                    qilish</a>
                            </div>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </section>

@endsection
