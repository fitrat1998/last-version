@extends('layouts.admin')

@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Yakuniy nazorat</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}">Bosh sahiha</a></li>
                        <li class="breadcrumb-item active">Yakuniy nazorat</li>
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
                        @can('attendance_log.create')
                            <a href="{{ route('finalexams.create') }}" class="btn btn-success btn-sm float-right">
                                <span class="fas fa-plus-circle"></span>
                                Qo'shish
                            </a>
                            <a href="" class="btn btn-danger" id="deleteAllSellected"> O'chirish</a>
                        @endcan
                    </div>

                    <div class="card-body">
                        <div class="card-body w-100" style="overflow:auto">
                            <!-- Data table -->
                            <table id="dataTable"
                                   class="table table-bordered table-striped dataTable dtr-inline table-responsive-lg"
                                   user="grid" aria-describedby="dataTable_info">
                                <thead>
                                <tr>
                                    <th>
                                        <div class="icheck-success">
                                            <input type="checkbox" name="" id="select_all_ids">
                                            <label for="select_all_ids" ></label>
                                        </div>
                                    </th>
                                    <th>#</th>
                                    <th>Test turi</th>
                                    <th>Fan</th>
                                    <th>Test soni</th>
                                    <th>Guruhlar</th>
                                    <th>Semester</th>
                                    <th>Urinishlar soni</th>
                                    <th>O'tish balli</th>
                                    <th>Boshlanish vaqti</th>
                                    <th>Tugash vaqti</th>
                                    <th>Amallar</th>

                                </tr>
                                </thead>
                                <tbody>
                                @foreach ($finalexams as $f)
                                     <tr id="datas_ids{{ $f->id }}">
                                        <td>
                                            <div class="icheck-success">
                                                <input type="hidden" name="" id="delete_url" value="{{ route('finalexams.DeleteAll') }}">
                                                <input type="checkbox" class="checkbox_ids" name="ids" id="checkboxSuccess.{{$f->id}}" value="{{ $f->id }}">
                                                <label for="checkboxSuccess.{{$f->id}}" >
                                                </label>
                                            </div>
                                        </td>
                                        <td style="width: 30px;">{{ $f->id }}</td>

                                        <td>{{ $f->examtype->name}}</td>

                                        <td>{{ $f->subject->subject_name ?? 0 }}</td>
                                        <td><a href="{{ route('attendance_logs.show', $f->id)}}"
                                               class="text-dark">{{$f->number}}</a></td>
                                        <td>{{ $f->group->name }}</td>
                                        <td>{{ $f->semester->semester_number }}</td>
                                        <td>{{ $f->attempts }}</td>
                                        <td>{{ $f->passing }}</td>
                                        <td>{{ $f->start }}</td>
                                        <td>{{ $f->end }}</td>

                                        <td class="text-center">
                                            @can('finalexam.destroy')
                                                <form action="{{ route('finalexams.destroy', $f->id) }}" method="post">
                                                    @csrf
                                                    <div class="btn-group">
                                                        @can('finalexam.edit')
                                                            <a href="{{ route('finalexams.edit', $f->id) }}"
                                                               type="button"
                                                               class="btn btn-info btn-sm m-1"><i
                                                                    class="fa fa-edit"></i></a>
                                                        @endcan
                                                        <input name="_method" type="hidden" value="DELETE">
                                                        <button type="button" class="btn btn-danger btn-sm"
                                                                onclick="if (confirm('Вы уверены?')) { this.form.submit() } ">
                                                            <i class="fa fa-trash"></i></button>
                                                    </div>
                                                </form>
                                            @endcan
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
