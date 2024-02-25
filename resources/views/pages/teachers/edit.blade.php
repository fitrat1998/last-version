@extends('layouts.admin')

@section('content')

    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>O'qituvchi</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}">@lang('global.home')</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('teachers.index') }}">O'qituvchi</a></li>
                        <li class="breadcrumb-item active">Tahrirlash</li>
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
                        <h3 class="card-title">Tahrirlash</h3>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">

                        <form action="{{ route('teachers.update',$teacher->id) }}" method="post"
                              enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            @method('PATCH')

                            <div class="form-group">
                                <label>Fish</label>
                                <input type="text" name="fullname"
                                       class="form-control {{ $errors->has('firstname') ? "is-invalid":"" }}"
                                       value="{{ old('fullname',$teacher->fullname) }}" required>
                                @if($errors->has('firstname'))
                                    <span class="error invalid-feedback">{{ $errors->first('firstname') }}</span>
                                @endif
                            </div>

                            <div class="form-group">
                                <label>Fakultetlar</label><br/>
                                <select class="form-control select2" name="faculties_id" id="faculties_id">
                                    @foreach($faculties as $faculty)
                                        <option
                                            value="{{ $faculty->id }}" {{ $faculty->id == $teacher->faculties_id ? "selected": '' }}>{{ $faculty->faculty_name }}
                                        </option>
                                    @endforeach


                                </select>
                            </div>

                            <div class="form-group">
                                <label>Daraja</label>
                                <input type="text" name="status"
                                       class="form-control {{ $errors->has('status') ? "is-invalid":"" }}"
                                       value="{{ old('status',$teacher->status) }}" required>
                                @if($errors->has('status'))
                                    <span class="error invalid-feedback">{{ $errors->first('status') }}</span>
                                @endif
                            </div>
                            <div class="form-group">
                                <label>Rasm</label>
                                <input type="file" name="photo" class="form-control"
                                       accept="image/png, image/gif, image/jpeg">
                                @if($errors->has('photo'))
                                    <span class="error invalid-feedback">{{ $errors->first('photo') }}</span>
                                @endif
                                <div class="form-group">
                                    <label>Email</label>
                                    <input type="text" name="email"
                                           class="form-control {{ $errors->has('email') ? "is-invalid":"" }}"
                                           value="{{ old('email',$teacher->email) }}" required>
                                    @if($errors->has('email'))
                                        <span class="error invalid-feedback">{{ $errors->first('email') }}</span>
                                    @endif
                                </div>
                                <div class="form-group">
                                    <label>Telefon raqam</label>
                                    <input type="text" name="phone"
                                           class="form-control {{ $errors->has('phone') ? "is-invalid":"" }}"
                                           value="{{ old('phone',$teacher->phone) }}" required>
                                    @if($errors->has('phone'))
                                        <span class="error invalid-feedback">{{ $errors->first('phone') }}</span>
                                    @endif
                                </div>
                                <div class="form-group">
                                    <label>Login</label>
                                    <input type="text" name="login"
                                           class="form-control {{ $errors->has('login') ? "is-invalid":"" }}"
                                           value="{{ old('login',$teacher->login) }}" required>
                                    @if($errors->has('login'))
                                        <span class="error invalid-feedback">{{ $errors->first('login') }}</span>
                                    @endif
                                </div>
                                <label>Parol</label>
                                <div class="form-group">
                                    <input type="password" name="password" id="password-field"
                                           class="form-control {{ $errors->has('password') ? "is-invalid":"" }}">
                                    <span toggle="#password-field"
                                          class="fa fa-fw fa-eye toggle-password field-icon"></span>
                                    @if($errors->has('password'))
                                        <span class="error invalid-feedback">{{ $errors->first('password') }}</span>
                                    @endif
                                </div>
                                <div class="form-group">
                                    <label>Parolni tasdqilash</label>
                                    <input id="password-confirm" type="password" class="form-control"
                                           name="password_confirmation" autocomplete="new-password">
                                    <span toggle="#password-confirm"
                                          class="fa fa-fw fa-eye toggle-password field-icon"></span>
                                    @if($errors->has('password_confirmation'))
                                        <span
                                            class="error invalid-feedback">{{ $errors->first('password_confirmation') }}</span>
                                    @endif
                                </div>
                                <div class="form-group">
                                    <button type="submit"
                                            class="btn btn-success float-right">@lang('global.save')</button>
                                    <a href="{{ route('teachers.index') }}" class="btn btn-default float-left">Bekor
                                        qilish</a>
                                </div>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </section>

@endsection
