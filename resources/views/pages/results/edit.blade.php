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
                        <li class="breadcrumb-item"><a href="{{ route('home') }}">@lang('global.home')</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('studentIndex') }}">Talaba</a></li>
                        <li class="breadcrumb-item active">Tahrirlash</li>
                    </ol>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>
    <!-- Main content -->
    {{ $id }}
    <section class="content">
        <div class="row">
            <div class="col-lg-8 offset-lg-2 col-sm-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Tahrirlash</h3>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">

                        <form action="{{ route('studentUpdate',$student->id) }}" method="post" enctype="multipart/form-data">
                            @csrf

                            <div class="form-group">
                                <label>Ism</label>
                                <input type="text" name="fullname" class="form-control {{ $errors->has('firstname') ? "is-invalid":"" }}" value="{{ old('fullname',$id) }}" required>
                                @if($errors->has('firstname'))
                                    <span class="error invalid-feedback">{{ $errors->first('firstname') }}</span>
                                @endif
                            </div>


                            <div class="form-group">
                                <button type="submit" class="btn btn-success float-right">@lang('global.save')</button>
                                <a href="{{ route('studentIndex') }}" class="btn btn-default float-left">@lang('global.cancel')</a>
                            </div>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </section>

@endsection
