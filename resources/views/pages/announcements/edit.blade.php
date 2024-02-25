@extends('layouts.admin')

@section('content')

<!-- Content Header (Page header) -->
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Fanlar</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}">@lang('global.home')</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('announcements.index') }}">Fanlar</a></li>
                    <li class="breadcrumb-item active">@lang('global.edit')</li>
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
                    <h3 class="card-title">@lang('global.edit')</h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body">

                    <form action="{{ route('announcements.update',$announcement->id)  }}" method="post">
                        @csrf
                        @method('PATCH')
                        <div class="form-group">
                            <label>Sarlavha</label><br />
                            <input type="text" name="title" class="form-control {{ $errors->has('name') ? "is-invalid":"" }}" value="{{ old('title',$announcement->title) }}" >
                            @if($errors->has('name'))
                            <span class="error invalid-feedback">{{ $errors->first('name') }}</span>
                            @endif
                        </div>
                        <div class="form-group">
                            <label>E'lon</label><br />
                            <textarea type="text" name="text" class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}" required>{{ old('text', $announcement->text) }}</textarea>

                            @if($errors->has('name'))
                            <span class="error invalid-feedback">{{ $errors->first('name') }}</span>
                            @endif
                        </div>




                        <div class="form-group">
                            <button type="submit" class="btn btn-success float-right">Saqlash</button>
                            <a href="{{ route('announcements.index') }}" class="btn btn-default float-left">Bekor qilish</a>
                        </div>
                    </form>


                </div>
            </div>
        </div>
    </div>
</section>

@endsection
