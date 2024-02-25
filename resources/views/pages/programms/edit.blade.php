@extends('layouts.admin')

@section('content')

    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>@lang('cruds.user.title')</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}">@lang('global.home')</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('userIndex') }}">@lang('cruds.user.title')</a></li>
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

                        <form action="{{ route('programmUpdate',$programm->id)  }}" method="post">
                            @csrf
                            <div class="form-group">
                                <label>Fakultet</label><br />
                                <select class="form-control" name="faculty_id" id="faculty_id">
                                    @foreach($faculties as $faculty)
                                    <option value = "{{ $faculty->id }}" {{ ($faculty->id == $programm->faculty_id ? "selected":'') }}>
                                        {{ $faculty->faculty_name }}
                                    </option>
                                    @endforeach
                                </select>
                                
                            </div>
                            <div class="form-group">
                                <label>Yo'nalish</label><br />
                                <select class="form-control" name="programm_name" id="programm_id">
                                    @foreach($programms as $p)
                                    <option value = "{{ $p->programm_name}}" {{ ($p->id == $programm->id ? "selected":'') }}>
                                        {{ $p->programm_name }}
                                    </option>
                                    @endforeach
                                </select>
                                
                            </div>
                         
                            <div class="form-group">
                                <button type="submit" class="btn btn-success float-right">Saqlash</button>
                                <a href="{{ route('groupIndex') }}" class="btn btn-default float-left">Bekor qilish</a>
                            </div>
                        </form>


                    </div>
                </div>
            </div>
        </div>
    </section>

@endsection
