@extends('layouts.admin')

@section('content')

    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Jurnal</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}">@lang('global.home')</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('attendance_logs.index') }}">Jurnal</a></li>
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

                        <form action="{{ route('attendance_logs.update',$attendance_log->id) }}" method="post" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            @method('PATCH')

                            <div class="form-group">
                                <label>Guruh</label><br />
                                <select class="form-control" name="group_id" id="group_id">
                                    @foreach($groups as $group)
                                    <option value = "{{ $group->id }}" {{ $group->id == ($attendance_log->group_id ? "selected":'') }}>{{ $group->group_number }}</option>
                                    @endforeach
                                </select>
                            </div>

                            
                            <div class="form-group">
                                <label>Fan</label><br />
                                <select class="form-control" name="subject_id" id="subject_id">
                                    @foreach($subjects as $subject)
                                    <option value = "{{ $subject->id }}" {{ $subject->id == ($attendance_log->program_id ? "selected":'') }}>{{ $subject->subject_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                
                            <div class="form-group">
                                <label>O'quv yili</label><br />
                                <select class="form-control" name="educationyear_id" id="educationyear_id">
                                    @foreach($educationyears as $educationyear)
                                    <option value = "{{ $educationyear->id }}" {{ $educationyear->id == ($attendance_log->educationyear_id ? "selected":'') }}>{{ $educationyear->education_year }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group">
                                <label>Semestr</label><br />
                                <select class="form-control" name="semester_id" id="semester_id">
                                    @foreach($semesters as $semester)
                                    <option value = "{{ $semester->id }}" {{ $semester->id == ($attendance_log->semester_id ? "selected":'') }}>{{ $semester->semester_number }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group">
                                <label>Dars turi</label><br />
                                <select class="form-control" name="lessontype_id" id="lessontype_id">
                                    @foreach($lessontypes as $lessontype)
                                    <option value = "{{ $lessontype->id }}" {{ $lessontype->id == ($attendance_log->lessontype_id ? "selected":'') }}>{{ $lessontype->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group">
                                <label>O'qituvchi</label><br />
                                <select class="form-control" name="teacher_id" id="teacher_id">
                                    @foreach($teachers as $teacher)
                                    <option value = "{{ $teacher->id }}" {{ $teacher->id == ($attendance_log->teacher_id ? "selected":'') }}>{{ $teacher->first_name }} {{ $teacher->last_name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group">
                                <button type="submit" class="btn btn-success float-right">Saqlash</button>
                                <a href="{{ route('attendance_logs.index') }}" class="btn btn-default float-left">Bekor qilish</a>
                            </div>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </section>

@endsection
