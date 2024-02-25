@extends('layouts.admin')

@section('content')

    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Oraliq nazorat</h1>
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

                        <form action="{{ route('middleexams.store') }}" method="post" enctype="multipart/form-data">
                            @csrf
                            <div class="form-group">
                                <label>Savollar soni</label>
                                <input type="text" name="number" class="form-control {{ $errors->has('name') ? "is-invalid":"" }}" value="{{ old('number') }}" required>
                                @if($errors->has('name'))
                                    <span class="error invalid-feedback">{{ $errors->first('name') }}</span>
                                @endif
                            </div>

                            <div class="form-group">
                                <label>Imtihon turi</label><br />
                                <select class="form-control select2" name="examtypes_id" id="examtypes_id">
                                    <option value="">imtihon turini tanlang</option>
                                    @foreach($examtypes as $examtype)
                                        <option value = "{{ $examtype->id }}" >{{ $examtype->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group">
                                <label>Guruh</label><br />
                                <select class="form-control select2" name="groups_id" id="group_id">
                                    <option value="">Guruhni tanlang</option>
                                    @foreach($groups as $group)
                                        <option value = "{{ $group->id }}" >{{ $group->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group">
                                <label>Fan</label><br />
                                <select class="form-control select2" name="subjects_id" id="subject_id" onchange="">
                                    <option value="">fanni tanlang</option>
                                    @foreach($subjects as $subject)
                                        <option value = "{{ $subject->id }}" >{{ $subject->subject_name }}</option>
                                    @endforeach
                                </select>
                            </div>


                            <div class="form-group">
                                <label>Mavzular</label>
                                <div class="select2-purple">
                                    <select class="select2 exam_topics" name="topics_id[]" multiple="multiple" data-placeholder="mavzularni tanlang" data-dropdown-css-class="select2-purple" style="width: 100%;" id="exam_topics">
                                        <option>-----</option>
                                    </select>
                                </div>
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
                                <label>Boshlanish vaqti:</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="far fa-calendar-alt"></i></span>
                                    </div>
                                    <input type="datetime-local" name="start" class="form-control" data-inputmask-alias="datetime" data-inputmask-inputformat="dd/mm/yyyy" data-mask>
                                </div>
                            </div>

                            <div class="form-group">
                                <label>Tugash vaqti:</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="far fa-calendar-alt"></i></span>
                                    </div>
                                    <input type="datetime-local" name="end" class="form-control" data-inputmask-alias="datetime" data-inputmask-inputformat="dd/mm/yyyy" data-mask>
                                </div>
                            </div>

                            <div class="form-group">
                                <label>Urinishlar soni</label>
                                <input type="number" name="attempts" class="form-control {{ $errors->has('name') ? "is-invalid":"" }}" value="{{ old('attempts') }}" required>
                                @if($errors->has('name'))
                                    <span class="error invalid-feedback">{{ $errors->first('name') }}</span>
                                @endif
                            </div>

                            <div class="form-group">
                                <label>O'tish bali</label>
                                <input type="number" name="passing" class="form-control {{ $errors->has('passing') ? "is-invalid":"" }}" value="{{ old('passing') }}" required>
                                @if($errors->has('passing'))
                                    <span class="error invalid-feedback">{{ $errors->first('passing') }}</span>
                                @endif
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
