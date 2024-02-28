@extends('layouts.admin')

@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-12">
                    <h1>O'qituvchi</h1>
                </div>
                <div class="col-sm-12">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}">Bosh sahiha</a></li>
                        <li class="breadcrumb-item active">O'qituvchilar</li>
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
                        @can('teacher.create')
                            <a href="{{ route('teachers.create') }}" class="btn btn-success btn-sm float-right">
                                <span class="fas fa-plus-circle"></span>
                                Qo'shish
                            </a>
                            <a href="" class="btn btn-danger" id="deleteAllSellected"> O'chirish</a>
                        @endcan

                        @if(session('success'))
                            <div class="alert alert-success">
                                {{ session('success') }}
                            </div>
                        @endif
                    </div>
                    <!-- /.card-header -->
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
                                <th>ID</th>
                                <th>Fish</th>
                                <th>Fakultet</th>
                                <th>Telefon raqam</th>
                                <th>Email</th>
                                <th>Login</th>
                                <th>Guruhlar</th>
                                <th>Rasm</th>
                                <th class="w-25">Amallar</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach ($teachers as $teacher)
                                <tr id="datas_ids{{ $teacher->id }}">
                                    <td>
                                        <div class="icheck-success">
                                            <input type="hidden" name="" id="delete_url"
                                                   value="{{ route('teachers.DeleteAll') }}">
                                            <input type="checkbox" class="checkbox_ids" name="ids"
                                                   id="checkboxSuccess.{{$teacher->id}}" value="{{ $teacher->id }}">
                                            <label for="checkboxSuccess.{{$teacher->id}}">
                                            </label>
                                        </div>
                                    </td>
                                    <td>{{ $teacher->id }}</td>
                                    <td>{{ $teacher->fullname }}</td>
                                    <td>
                                        @if($teacher->faculties)
                                            {{ $teacher->faculties->faculty_name }}
                                        @else

                                        @endif
                                    </td>


                                    <td>{{ $teacher->phone }}</td>
                                    <td>{{ $teacher->email }}</td>
                                    <td>{{ $teacher->login }}</td>
                                    <td>
                                        @foreach($teacher->attach_group($teacher->id) as $g)
                                            <span class="btn btn-info p-0">{{ $g->name }}</span>
                                        @endforeach
                                    </td>

                                    <td><img src="{{ asset('storage/teacher-photos/'.$teacher->photo)}}" alt="Rasm">
                                    </td>


                                    <td class="">
                                        @can('teacher.destroy')
                                            <form action="{{ route('teachers.destroy', $teacher->id) }}" method="post">
                                                @csrf
                                                <div class="btn-group">
                                                    @can('teacher.edit')
                                                        <a href="{{ route('teachers.edit', $teacher->id) }}"
                                                           type="button"
                                                           class="btn btn-info btn-sm">Tahrirlash</a>
                                                    @endcan
                                                    <input name="_method" type="hidden" value="DELETE">
                                                    <button type="button" class="btn btn-danger btn-sm"
                                                            onclick="if (confirm('Вы уверены?')) { this.form.submit() } ">
                                                        O'chirish
                                                    </button>
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
