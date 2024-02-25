@extends('layouts.admin')

@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-12">
                    <h1>Dars</h1>
                </div>
                <div class="col-sm-12">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}">Bosh sahiha</a></li>
                        <li class="breadcrumb-item active">Dars </li>
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
                        <h3 class="card-title">Fan</h3>
                        @can('attendance_log.add')
                            <a href="{{ route('attendance_logs.create') }}" class="btn btn-success btn-sm float-right">
                                <span class="fas fa-plus-circle"></span>
                                Qo'shish
                            </a>
                        @endcan
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
                            <tbody>
                                @foreach ($exercises as $key => $v)
                                {{ $v }}
                                    <tr>
                                        <td class="w-5">{{ $v->id }}</td><br />
                                        <td class="w-5">{{ $v->title }}</td>
                                        <td class="w-5">{{ $v->lessontype->name }}</td>
                                        <td class="w-5">{{ $v->teacher->first_name }} {{ $v->teacher->last_name }}</td>
                                        <td>
                                            <a href="{{ route('attendance_check.show', $v->id) }}" class="btn btn-info">Yo'qlama qilish</a>
                                        </td>
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
