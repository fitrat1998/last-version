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
                    <!-- <div class="card-body">
                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <h4>Fakultet</h4>

                                    <input type="hidden" name="url_faculty" value="{{route('teachersData')}}" 
                                    id="url_faculty_result">

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
                                    <input type="hidden" name="url_groups" value="{{route('groupShow')}}" id="url_group_result">
                                <select class="select2" data-placeholder="guruhni tanlang" style="width: 100%;" id="attendance_groups_id">
                                    <option>----</option>

                                </select>
                                </div>
                            </div>


                        </div>
                    </div> -->

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
                                <th>To'gri javoblar soni</th>
                               
                            </tr>
                            </thead>
                            <tbody>

                            @foreach ($results as $result)
                                <tr id="datas_ids{{ $result->id }}">

                                    <td>{{ $result->id }}</td>
                                    <td>{{ optional($result->student($result->users_id))->fullname ?? "Malumotlar mavjud emas!" }}</td>

                                    <td>{{ optional($result->group($result->users_id))->name ?? "Malumotlar mavjud emas!" }}</td>

                                    <td>{{ optional($result->examtype($result->examtypes_id))->name ?? "Malumotlar mavjud emas!" }}</td>
                                    
                                    <td>{{ $result->subject($result->subjects_id) ?? "Malumotlar mavjud emas!" }}</td>

                                    <td>{{ $result->semester($result->semesters_id) ?? "Malumotlar mavjud emas!" }}</td>


                                    <td>{{ $result->ball ?? "0" }}</td>
                                    <td>{{ $result->correct ?? "0" }}</td>
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
