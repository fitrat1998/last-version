@extends('layouts.admin')

@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Dars jadvali</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}">Bosh sahiha</a></li>
                        <li class="breadcrumb-item active">Dars jadvallari</li>
                    </ol>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Dars jadvali</h3>
{{--                        @can('attendance_log.create')--}}
                            <a href="{{ route('attendance_logs.attendance-results') }}" class="btn btn-success btn-sm float-right">
                                <span class="fas fa-list"></span>
                                Davomat natijalari
                            </a>
{{--                        @endcan--}}
                    </div>

                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <h4>Fakultet</h4>
                                    <input type="hidden" name="url_faculty" value="{{route('facultyShow')}}" id="url_faculty">
                                    <select class="select2" name="faculty" data-placeholder="Semestrni tanlang" style="width: 100%;" id="attendance_faculty">
                                        <option>fakultetni tanlang</option>
                                        @foreach($faculties as $f)
                                            <option value="{{ $f->id  }}">{{ $f->faculty_name  }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <h4>Guruh</h4>
                                    <input type="hidden" name="url_groups" value="{{route('groupShow')}}" id="url_groups">
                                <select class="select2" data-placeholder="guruhni tanlang" style="width: 100%;" id="attendance_groups_id">
                                    <option>----</option>

                                </select>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <h4>Fan</h4>
                                    <input type="hidden" name="url_subjects" value="{{route('subjectShow')}}" id="url_subjects">
                                    <select class="select2" data-placeholder="fanni tanlang" style="width: 100%;" id="attendance_subjects_id">

                                </select>
                                </div>
                            </div>

                        </div>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body w-100" style="overflow:auto">
                        <!-- Data table -->
                        <table id="dataTable"
                            class="table table-bordered table-striped dataTable dtr-inline table-responsive-lg"
                            user="grid" aria-describedby="dataTable_info">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Sarlavha</th>
                                    <th>Dars turi</th>
                                    <th>O'qituvchi</th>
                                    <th>Davomat</th>
                                </tr>
                            </thead>
{{--                            <input type="hidden" name="url_attendance_check" value="{{route('attendance_checks.show','/')}}" id="url_attendance_check">--}}
{{--                            <input type="hidden" name="url_attendance_check" value="{{ route('attendance_checks.index') }}" id="url_attendance_check">--}}

                            <tbody>



                            </tbody>
                        </table>
                    </div>
                    <!-- /.card-body -->
                </div>
                <!-- /.card -->
            </div>
            <!-- /.col -->
        </div>
        <!-- /.row -->
    </section>
    <!-- /.content -->
@endsection
