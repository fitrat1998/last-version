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
                        <li class="breadcrumb-item active">Davomat natijalari</li>
                    </ol>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>git

    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Davomat natijalari</h3>
                    </div>

                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <h4>Fakultet</h4>
                                    <input type="hidden" name="url_faculty" value="{{route('facultyShow')}}" id="url_faculty_result">
                                    <select class="select2" name="faculty" data-placeholder="Semestrni tanlang" style="width: 100%;" id="attendance_faculty_result">
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
                                    <input type="hidden" name="url_groups" value="{{route('groupShow2')}}" id="url_groups_result">
                                    <select class="select2" data-placeholder="guruhni tanlang" style="width: 100%;" id="attendance_groups_id_result">
                                    <option>----</option>

                                </select>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <h4>Fan</h4>
                                    <input type="hidden" name="url_subjects" value="{{route('subjectShow2')}}" id="url_subjects_result">
                                    <select class="select2" data-placeholder="fanni tanlang" style="width: 100%;" id="attendance_subjects_id_result">

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
                                    <th>Talaba</th>
                                    <th>Qatnashganligi</th>
                                    <th>Sanasi</th>
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
