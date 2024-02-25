@extends('layouts.admin')

@section('content')

    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Mavzu</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}">Bosh sahifa</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('userIndex') }}">Mavzular</a></li>
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
                        <h3 class="card-title">@lang('global.edit')</h3>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">

                        <form action="{{ route('topics.update',$topic->id)  }}" method="post">
                            @csrf
                            @method('PUT')
                            @method('PATCH')
                                
                            <div class="form-group">
                                <label>Fan</label><br />
                                <select class="form-control" name="subject_id" id="subject_id">
                                    @foreach($subjects as $subject)
                                    <option value = "{{ $subject->id }}" {{ ($subject->id == $topic->subject_id ? "selected":'') }}>
                                        {{ $subject->subject_name }}
                                    </option>
                                    @endforeach
                                </select>
                            </div>
                            
                            <div class="form-group">
                                <label>Mavzu nomi</label>
                                <input type="text" name="topic_name" class="form-control {{ $errors->has('name') ? "is-invalid":"" }}" value="{{ old('topic_name',$topic->topic_name) }}" required>
                                @if($errors->has('name'))
                                    <span class="error invalid-feedback">{{ $errors->first('name') }}</span>
                                @endif
                            </div>

                            <div class="form-group">
                                <button type="submit" class="btn btn-success float-right">Saqlash</button>
                                <a href="{{ route('topics.index') }}" class="btn btn-default float-left">Bekor qilish</a>
                            </div>
                        </form>


                    </div>
                </div>
            </div>
        </div>
    </section>

@endsection
