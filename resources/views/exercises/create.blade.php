@extends('layouts.admin')

@section('content')

    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Darslik</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}">Bosh sahifa</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('exercises.index') }}">Darsliklar</a></li>
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

                        <form action="{{ route('exercises.store') }}" method="post" enctype="multipart/form-data">
                            @csrf

                            <div class="form-group">
                                <label>Sarlavha</label>
                                <input type="text" name="title" class="form-control {{ $errors->has('title') ? "is-invalid":"" }}" value="{{ old('title') }}" required>
                                @if($errors->has('title'))
                                    <span class="error invalid-feedback">{{ $errors->first('title') }}</span>
                                @endif
                            </div>

                            <div class="form-group">
                                <label>O'tilgan vaqt:</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="far fa-calendar-alt"></i></span>
                                    </div>
                                    <input type="datetime-local" name="date" class="form-control" data-inputmask-alias="datetime" data-inputmask-inputformat="dd/mm/yyyy" data-mask>
                                </div>
                            </div>

                            <div class="form-group">
                                <label>Guruh</label><br />
                                <select class="form-control select2" name="groups_id" id="exercises_group_id">
                                    <option value="">guruhni tanlang</option>
                                    @foreach($groups as $group)
                                        <option value = "{{ $group->id }}" >{{ $group->name }}</option>
                                    @endforeach

                                </select>
                            </div>
                            <div class="form-group">
                                <label>Fan</label><br />
                                <select class="form-control exercises_subject_id select2" name="subjects_id" id="exercises_subject_id">
                                    <option value="">fanni tanlang</option>
                                </select>
                            </div>

                            <div class="form-group">
                                <label>Mavzu</label><br />
                                <select class="form-control select2" name="topics_id" id="topics_id">
                                    <option value="">mavzuni tanlang</option>
                                </select>
                            </div>

                            <div class="form-group">
                                <label>O'quv yili</label><br />
                                <select class="form-control select2" name="educationyear_id" id="educationyear_id">
                                    <option value="">o'quv yilini tanlang</option>
                                    @foreach($educationyears as $educationyear)
                                        <option value = "{{ $educationyear->id }}" >{{ $educationyear->education_year }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group">
                                <label>Semestr</label><br />
                                <select class="form-control select2" name="semesters_id" id="semester_id">
                                    <option value="">semestrni tanlang</option>
                                    @foreach($semesters as $semester)
                                        <option value = "{{ $semester->id }}" >{{ $semester->semester_number }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Dars turi</label><br />
                                <select class="form-control select2" name="lessontypes_id" id="lessontype_id">
                                    <option value="">dars turini tanlang</option>
                                    @foreach($lessontypes as $lessontype)
                                        <option value = "{{ $lessontype->id }}" >
                                            {{ $lessontype->name}}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label>O'qituvchi</label><br />
                                <select class="form-control select2" name="teachers_id" id="teacher_id">
                                    <option value="">O'qituvchini tanlang</option>
                                    @foreach($teachers as $teacher)
                                        <option value = "{{ $teacher->id }}" >
                                            {{ $teacher->fullname }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group">
                                <button type="submit" class="btn btn-success float-right">Saqlash</button>
                                <a href="{{ route('exercises.index') }}" class="btn btn-default float-left">Bekor qilish</a>
                            </div>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </section>

@endsection
