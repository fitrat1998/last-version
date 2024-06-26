@extends('layouts.admin')

@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-12">
                    <h1>Natija</h1>
                </div>
                <div class="col-sm-12">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}">Bosh sahiha</a></li>
                        <li class="breadcrumb-item active">Natijalar</li>
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
                        @if(session('error'))
                            <div class="alert alert-danger">
                                {{ session('error') }}
                            </div>
                        @endif
                        @if(session('success'))
                            <div class="alert alert-success">
                                {{ session('success') }}
                            </div>
                        @endif
                    </div>

                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <h4>Yo'nalish</h4>

                                    <input type="hidden" name="url_result_programm" value="{{route('programmShow2')}}"
                                           id="url_result_programm">

                                    <select class="select2" name="result_programm" data-placeholder="Semestrni tanlang"
                                            style="width: 100%;" id="result_programm">
                                        <option>yo'nalishni tanlang</option>
                                        @foreach($programms as $p)
                                            <option value="{{ $p->id  }}">{{ $p->programm_name  }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <h4>Guruh</h4>
                                    <input type="hidden" name="url_result_groups" value="{{route('groupShow2')}}"
                                           id="url_group_result">
                                    <select class="select2" data-placeholder="guruhni tanlang" style="width: 100%;"
                                            id="group_result">

                                    </select>
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="form-group">
                                    <h4>Fan</h4>
                                    <input type="hidden" name="url_subjects" value="{{route('educationyearShow2')}}"
                                           id="url_subject_result">
                                    <select class="select2" data-placeholder="fanni tanlang" style="width: 100%;"
                                            id="subject_result">
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="form-group">
                                    <h4>O'quv yili</h4>
                                    <input type="hidden" name="url_educationyear_result"
                                           value="{{route('examtypes.show2')}}" id="url_educationyear_result">
                                    <label for="educationyear_result"></label>
                                    <select class="select2" data-placeholder="fanni tanlang" style="width: 95%;"
                                            id="educationyear_result">

                                    </select>
                                </div>
                            </div>

                        </div>
                    </div>

                    <!-- /.card-header -->
                    <div class="card-body w-100" style="overflow:auto">
                        <!-- Data table -->
                        <table id="exam_result"
                               class="table btn_res table-bordered table-striped dataTable dtr-inline table-responsive-lg"
                               user="grid" aria-describedby="dataTable_info">
                            <thead>
                            <tr>
                                <th>ID</th>
                                <th>Fish</th>
                                <th>Joriy nazorat</th>
                                <th><i class="fa fa-pencil"></i></th>
                                <th>Oraliq nazorat</th>
                                <th><i class="fa fa-pencil"></i></th>
                                <th>Mustaqil ta`lim</th>
                                <th>Yakuniy nazorat</th>
                                <th><i class="fa fa-pencil"></i></th>
                                <th>Umumiy</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                            </tr>
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
