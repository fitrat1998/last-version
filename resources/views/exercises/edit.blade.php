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
                        <li class="breadcrumb-item"><a href="{{ route('exercises.index') }}">Darslik</a></li>
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

                        <form action="{{ route('exercises.update',$exercises->id) }}" method="post" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            @method('PATCH')

                            <div class="form-group">
                                <label>Mavzu nomi</label>
                                <input type="text" name="title" class="form-control {{ $errors->has('name') ? "is-invalid":"" }}" value="{{ old('title',$exercises->title) }}" required>
                                @if($errors->has('name'))
                                    <span class="error invalid-feedback">{{ $errors->first('name') }}</span>
                                @endif
                            </div>

                            <div class="form-group">
                            <label>O'tilgan vaqt:</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="far fa-calendar-alt"></i></span>
                                    </div>
                                    <input type="datetime-local" name="date" class="form-control" data-inputmask-alias="datetime"
                                    data-inputmask-inputformat="dd/mm/yyyy" data-mask value="{{ old('date',$exercises->date) }}">
                                </div>
                            </div>

                            <div class="form-group">
                                <label>Guruh</label><br />
                                <select class="form-control" name="group_id" id="group_id">
                                    @foreach($groups as $group)
                                    <option value = "{{ $group->id }}" {{ $group->id == ($exercises->group_id ? "selected":'') }}>{{ $group->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group">
                                <label>Fan</label><br />
                                <select class="form-control" name="subject_id" id="subject_id">
                                    @foreach($subjects as $subject)
                                    <option value = "{{ $subject->id }}" {{ $subject->id == ($exercises->program_id ? "selected":'') }}>{{ $subject->subject_name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group">
                                <label>O'quv yili</label><br />
                                <select class="form-control" name="educationyear_id" id="educationyear_id">
                                    @foreach($educationyears as $educationyear)
                                    <option value = "{{ $educationyear->id }}" {{ $educationyear->id == ($exercises->educationyear_id ? "selected":'') }}>{{ $educationyear->education_year }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group">
                                <label>Semestr</label><br />
                                <select class="form-control" name="semester_id" id="semester_id">
                                    @foreach($semesters as $semester)
                                    <option value = "{{ $semester->id }}" {{ $semester->id == ($exercises->semester_id ? "selected":'') }}>{{ $semester->semester_number }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group">
                                <label>Dars turi</label><br />
                                <select class="form-control" name="lessontype_id" id="lessontype_id">
                                    @foreach($lessontypes as $lessontype)
                                    <option value = "{{ $lessontype->id }}" {{ $lessontype->id == ($exercises->lessontype_id ? "selected":'') }}>{{ $lessontype->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group">
                                <label>O'qituvchi</label><br />
                                <select class="form-control" name="teacher_id" id="teacher_id">
                                    @foreach($teachers as $teacher)
                                    <option value = "{{ $teacher->id }}" {{ $teacher->id == ($exercises->teacher_id ? "selected":'') }}>{{ $teacher->first_name }} {{ $teacher->last_name }}</option>
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
