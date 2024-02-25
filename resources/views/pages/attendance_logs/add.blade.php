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
                        <li class="breadcrumb-item"><a href="{{ route('home') }}">Bo'sh sahifa</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('attendance_logs.index') }}">Jurnallar</a></li>
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
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">

                        <form action="{{ route('attendance_logs.store') }}" method="post" enctype="multipart/form-data">
                            @csrf
                            <div class="form-group">
                                <label>Guruh</label><br />
                                <select class="form-control select2" name="group_id" id="group_id">
                                    <option value="">Guruhni tanlang</option>
                                    @foreach($groups as $group)
                                    <option value = "{{ $group->id }}" >{{ $group->group_number }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Fan</label><br />
                                <select class="form-control select2" name="subject_id" id="subject_id">
                                    <option value="">Fanni tanlang</option>
                                    @foreach($subjects as $subject)
                                    <option value = "{{ $subject->id }}" >{{ $subject->subject_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label>O'quv yili</label><br />
                                <select class="form-control select2" name="educationyear_id" id="educationyear_id">
                                    <option value="">O'quv yilini tanlang</option>
                                    @foreach($educationyears as $educationyear)
                                    <option value = "{{ $educationyear->id }}" >{{ $educationyear->education_year }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Semestr</label><br />
                                <select class="form-control select2" name="semester_id" id="semester_id">
                                    <option value="">Semestrni tanlang</option>
                                    @foreach($semesters as $semester)
                                    <option value = "{{ $semester->id }}" >{{ $semester->semester_number }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Dars turi</label><br />
                                <select class="form-control select2" name="lessontype_id" id="lessontype_id">
                                    <option value="">Dars turini tanlang</option>
                                    @foreach($lessontypes as $lessontype)
                                    <option value = "{{ $lessontype->id }}" >
                                        {{ $lessontype->name}}
                                    </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label>O'qituvchi</label><br />
                                <select class="form-control select2" name="teacher_id" id="teacher_id">
                                    <option value="">O'qituvchini tanlang</option>
                                    @foreach($teachers as $teacher)
                                    <option value = "{{ $teacher->id }}" >
                                        {{ $teacher->first_name }}
                                        {{ $teacher->last_name }}
                                    </option>
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
