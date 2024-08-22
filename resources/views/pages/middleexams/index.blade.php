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
                        <li class="breadcrumb-item"><a href="{{ route('home') }}">Bosh sahiha</a></li>
                        <li class="breadcrumb-item active">Oraliq nazorat</li>
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
                            <a href="{{ route('middleexams.create') }}" class="btn btn-success btn-sm float-right">
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
                                            <label for="select_all_ids"></label>
                                        </div>
                                    </th>
                                    <th>#</th>
                                    <th>Test turi</th>
                                    <th>Fan</th>
                                    <th>Test soni</th>
                                    <th>Guruhlar</th>
                                    <th>Semester</th>
                                    <th>Boshlanish vaqti</th>
                                    <th>Tugash vaqti</th>
                                    <th>Urinishlar soni</th>
                                    <th>O'tish bali</th>
                                    <th>Test davomiyligi</th>
                                    <th>Amallar</th>

                                </tr>
                                </thead>
                                <tbody>
                                @if($middleexams)
                                    @foreach ($middleexams as $m)
                                        <tr id="datas_ids{{ $m->id }}">
                                            <td>
                                                <div class="icheck-success">
                                                    <input type="hidden" name="" id="delete_url"
                                                           value="{{ route('middleexams.DeleteAll') }}">
                                                    <input type="checkbox" class="checkbox_ids" name="ids"
                                                           id="checkboxSuccess.{{$m->id}}" value="{{ $m->id }}">
                                                    <label for="checkboxSuccess.{{$m->id}}">
                                                    </label>
                                                </div>
                                            </td>
                                            <td style="width: 30px;">{{ $m->id }}</td>

                                            <td>{{ $m->examtype->name}}</td>

                                            <td>{{ $m->subject->subject_name ?? 0 }}</td>
                                            <td><a href="{{ route('attendance_logs.show', $m->id)}}"
                                                   class="text-dark">{{$m->number}}</a></td>
                                            <td>{{ $m->group->name }}</td>
                                            <td>{{ $m->semester->semester_number }}</td>
                                            <td>{{ $m->start }}</td>
                                            <td>{{ $m->end }}</td>
                                            <td>{{ $m->attempts}}</td>
                                            <td>{{ $m->passing}}</td>
                                            <td>
                                                {{ $m->duration($m->id) ?? 0 }}
                                            </td>

                                            <td class="text-center">
                                                @can('middleexam.destroy')
                                                    <form action="{{ route('middleexams.destroy', $m->id) }}"
                                                          method="post">
                                                        @csrf
                                                        <div class="btn-group">
                                                            @can('middleexam.edit')
                                                                <a href="{{ route('middleexams.edit', $m->id) }}"
                                                                   type="button"
                                                                   class="btn btn-info btn-sm m-1"> <i
                                                                        class="fa fa-edit"></i> </a>
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
                                @endif
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
