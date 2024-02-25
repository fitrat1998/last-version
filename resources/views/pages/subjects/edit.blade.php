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
                    <li class="breadcrumb-item"><a href="{{ route('subjectIndex') }}">Fanlar</a></li>
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

                    <form action="{{ route('subjectUpdate',$subject->id)  }}" method="post">
                        @csrf
                        <div class="form-group">
                            <label>Fanlar</label><br />
                            <input type="text" name="subject_name" class="form-control {{ $errors->has('name') ? "is-invalid":"" }}" value="{{ old('subject_name',$subject->subject_name) }}" required>
                            @if($errors->has('name'))
                            <span class="error invalid-feedback">{{ $errors->first('name') }}</span>
                            @endif

                        </div>

                        <div class="form-group">
                            <label>Guruhlar</label>

                            <select class="duallistbox" multiple="multiple" name="groups_id[]">
                                @foreach($groups as $g)
                                    <option value="{{ $g->id }}" @if(\App\Models\Subject::check($subject->id,$g->id)) selected @endif> {{ $g->name }}</option>
                                @endforeach
                            </select>

                        </div>


                        <div class="form-group">
                            <button type="submit" class="btn btn-success float-right">Saqlash</button>
                            <a href="{{ route('subjectIndex') }}" class="btn btn-default float-left">Bekor qilish</a>
                        </div>
                    </form>


                </div>
            </div>
        </div>
    </div>
</section>

@endsection
