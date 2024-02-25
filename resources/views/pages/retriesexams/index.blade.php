@extends('layouts.admin')

@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Qayta topshirish</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}">Bosh sahiha</a></li>
                        <li class="breadcrumb-item active">Qayta topshirish</li>
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
                            <a href="{{ route('retriesexams.create') }}" class="btn btn-success btn-sm float-right">
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
                                    <th>O'tish bali</th>
                                    <th>Boshlanish vaqti</th>
                                    <th>Tugash vaqti</th>
                                    <th>Amallar</th>

                                </tr>
                                </thead>
                                <tbody>
                                @foreach ($retriesexams as $r)
                                     <tr id="datas_ids{{ $r->id }}">
                                        <td>
                                            <div class="icheck-success">
                                                <input type="hidden" name="" id="delete_url" value="{{ route('retriesexams.DeleteAll') }}">
                                                <input type="checkbox" class="checkbox_ids" name="ids" id="checkboxSuccess.{{$r->id}}" value="{{ $r->id }}">
                                                <label for="checkboxSuccess.{{$r->id}}" >
                                                </label>
                                            </div>
                                        </td>
                                        <td style="width: 30px;">{{ $r->id }}</td>

                                        <td>{{ $r->examtype->name}}</td>

                                        <td>{{ $r->subject->subject_name ?? 0}}</td>
                                        <td><a href="{{ route('attendance_logs.show', $r->id)}}" class="text-dark">{{$r->number}}</a></td>
                                        <td>{{ $r->group->name }}</td>
                                        <td>{{ $r->semester->semester_number }}</td>
                                        <td>{{ $r->attempts }}</td>
                                        <td>{{ $r->passing }}</td>
                                        <td>{{ $r->start }}</td>
                                        <td>{{ $r->end }}</td>

                                        <td class="text-center">
                                            @can('retryexam.destroy')
                                                <form action="{{ route('retriesexams.destroy', $r->id) }}" method="post">
                                                    @csrf
                                                    <div class="btn-group">
                                                        @can('retryexam.edit')
                                                            <a href="{{ route('retriesexams.edit', $r->id) }}" type="button"
                                                               class="btn btn-info btn-sm m-1"><i class="fa fa-edit"></i></a>
                                                        @endcan
                                                        <input name="_method" type="hidden" value="DELETE">
                                                        <button type="button" class="btn btn-danger btn-sm"
                                                                onclick="if (confirm('Вы уверены?')) { this.form.submit() } "><i class="fa fa-trash"></i></button>
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
