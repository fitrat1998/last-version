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
                        @can('result.create')
                          <!--   <a href="{{ route('results.create') }}" class="btn btn-success btn-sm float-right">
                                <span class="fas fa-plus-circle"></span>
                                Qo'shish
                            </a>
                            <a href="" class="btn btn-danger" id="deleteAllSellected"> O'chirish</a> -->
                        @endcan
                    </div>
                    @if(session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <h4>Yo'nalish</h4>

                                    <input type="hidden" name="url_result_programm" value="{{route('programmShow')}}"
                                    id="url_result_programm">

                                    <select class="select2" name="faculty" data-placeholder="Semestrni tanlang" style="width: 100%;" id="result_programm">
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
                                    <input type="hidden" name="url_result_groups" value="{{route('groupShow2')}}" id="url_group_result">
                                <select class="select2" data-placeholder="guruhni tanlang" style="width: 100%;" id="group_result">
                                    <option>----</option>

                                </select>
                                </div>
                            </div>

                             <div class="col-md-3">
                                <div class="form-group">
                                    <h4>Fan</h4>
                                    <input type="hidden" name="url_subjects" value="{{route('examtypes.show2')}}" id="url_subject_result">
                                    <select class="select2" data-placeholder="fanni tanlang" style="width: 100%;" id="subject_result">

                                </select>
                                </div>
                            </div>

                             <div class="col-md-3">
                                <div class="form-group">
                                    <h4>Imtihon turi</h4>
                                    <input type="hidden" name="url_subjects" value="{{route('results.getDataExam')}}" id="url_examtype_result">
                                    <select class="select2" data-placeholder="imtihon turini tanlang" style="width: 100%;" id="examtype_result">

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
                                <th>ID</th>
                                <th>Fish</th>
                                <th>Guruh</th>
                                <th>Imtihon turi</th>
                                <th>Fan</th>
                                <th>Semester</th>
                                <th>Ball</th>
{{--                                <th>To'gri javoblar soni</th>--}}

                            </tr>
                            </thead>
                            <tbody>

                            @foreach ($results as $result)
                                <tr id="datas_ids{{ $result->id }}">

{{--                                    <td>{{ $result->id }}</td>--}}
{{--                                    <td>{{ optional($result->student($result->users_id))->fullname ?? "Malumotlar mavjud emas!" }}</td>--}}

{{--                                    <td>{{ optional($result->group($result->users_id))->name ?? "Malumotlar mavjud emas!" }}</td>--}}

{{--                                    <td>{{ optional($result->examtype($result->examtypes_id))->name ?? "Malumotlar mavjud emas!" }}</td>--}}

{{--                                    <td>{{ $result->subject($result->subjects_id) ?? "Malumotlar mavjud emas!" }}</td>--}}

{{--                                    <td>{{ $result->semester($result->semesters_id) ?? "Malumotlar mavjud emas!" }}</td>--}}


{{--                                    <td>{{ $result->ball ?? "0" }}</td>--}}
{{--                                    <td>{{ $result->correct ?? "0" }}</td>--}}
                                </tr>


                                </tr>
                            @endforeach
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
