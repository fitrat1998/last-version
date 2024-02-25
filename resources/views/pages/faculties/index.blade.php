@extends('layouts.admin')

@section('content')
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Fakultetlar</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('home') }}">Bosh sahifa</a></li>
                            <li class="breadcrumb-item active">Fakultetlar</li>
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
                            @can('faculty.create')
                            <a href="{{ route('facultyAdd') }}" class="btn btn-success btn-sm float-right">
                            <span class="fas fa-plus-circle"></span>
                                Fakultet qo'shish
                            </a>
                             <a href="" class="btn btn-danger" id="deleteAllSellected"> O'chirish</a>
                            @endcan
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <!-- Data table -->
                            <table id="dataTable" class="table table-bordered table-striped dataTable dtr-inline table-responsive-lg" user="grid" aria-describedby="dataTable_info">
                                <thead>
                                <tr>
                                    <th>
                                        <div class="icheck-success">
                                            <input type="checkbox" name="" id="select_all_ids">
                                            <label for="select_all_ids" ></label>
                                        </div>
                                    </th>
                                    <th>ID</th>
                                    <th>Fakultet</th>
                                    <th>Yo'nalishlar</th>
                                    <th>Amallar</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($faculties as $faculty)
                                    <tr id="datas_ids{{ $faculty->id }}">
                                        <td>
                                            <div class="icheck-success">
                                                <input type="hidden" name="" id="delete_url" value="{{ route('facultyDeleteAll') }}">
                                                <input type="checkbox" class="checkbox_ids" name="ids" id="checkboxSuccess.{{$faculty->id}}" value="{{ $faculty->id }}">
                                                <label for="checkboxSuccess.{{$faculty->id}}" >
                                                </label>
                                            </div>
                                        </td>
                                        <td>{{ $faculty->id }}</td>
                                        <td>{{ $faculty->faculty_name }}</td>
                                        <td>
                                            @foreach ($faculty->program as $p)
                                                <span class="badge bg-info">{{ $p->programm_name }}</span>
                                            @endforeach
                                        </td>
                                        <td class="text-center">
                                            @can('faculty.destroy')
                                            <form action="{{ route('facultyDestroy',$faculty->id) }}" method="post">
                                                @csrf
                                                <div class="btn-faculty">
                                                    @can('faculty.edit')
                                                    <a href="{{ route('facultyEdit',$faculty->id) }}" type="button" class="btn btn-info btn-sm"> Tahrirlash</a>
                                                    @endcan
                                                    <input name="_method" type="hidden" value="DELETE">
                                                    <button type="button" class="btn btn-danger btn-sm" onclick="if (confirm('Вы уверены?')) { this.form.submit() } "> O'chirish</button>
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
