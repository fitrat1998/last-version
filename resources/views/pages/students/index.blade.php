@extends('layouts.admin')

@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-12">
                    <h1>Talaba</h1>
                </div>
                <div class="col-sm-12">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}">Bosh sahiha</a></li>
                        <li class="breadcrumb-item active">Talabalar</li>
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
                        @can('student.create')
                            <a href="{{ route('studentAdd') }}" class="btn btn-success btn-sm float-right">
                                <span class="fas fa-plus-circle"></span>
                                Qo'shish
                            </a>
                            <a href="" class="btn btn-danger" id="deleteAllSellected"> O'chirish</a>
                        @endcan
                    </div>
                    @if(session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif
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
                                    <label for="select_all_ids" ></label>
                                  </div>
                                </th>
                                <th>ID</th>
                                <th>Fish</th>
                                <th>Yo'nalish</th>
                                <th>Telefon raqam</th>
                                <th>Email</th>
                                <th>Login</th>
                                <th>Rasm</th>
                                <th>Guruhi</th>
                                <th>Amallar</th>
                            </tr>
                            </thead>
                            <tbody>
                            @php
                                $i = 0;
                            @endphp
                            @foreach ($students as $student)

                                <tr id="datas_ids{{ $student->id }}">
                                    <td>
                                        <div class="icheck-success">
                                            <input type="hidden" name="" id="delete_url" value="{{ route('studentDeleteAll') }}">
                                            <input type="checkbox" class="checkbox_ids" name="ids" id="checkboxSuccess.{{$student->id}}" value="{{ $student->id }}">
                                            <label for="checkboxSuccess.{{$student->id}}" >
                                            </label>
                                        </div>
                                    </td>
                                    <td>{{ $loop->index + 1 }}</td>
                                    <td>{{ $student->fullname }}</td>
                                    <td>{{ $programms->find($student->programm_id)->programm_name }}</td>
                                    <td>{{ $student->phone }}</td>
                                    <td>{{ $student->email }}</td>
                                    <td>{{ $student->login }}</td>
                                    <td><img src="{{ asset('storage/user-photos/'.$student->photo)}}" alt="Rasm"></td>
                                    <td>
                                        {{ $student->group() }}
                                    </td>

                                    <td class="text-center">
                                        @can('student.destroy')
                                            <form action="{{ route('studentDestroy', $student->id) }}" method="post">
                                                @csrf
                                                <div class="btn-group">
                                                    @can('student.edit')
                                                        <a href="{{ route('studentEdit', $student->id) }}" type="button"
                                                           class="btn btn-info btn-sm"><i class="fa fa-edit"></i></a>
                                                    @endcan
                                                    <input name="_method" type="hidden" value="DELETE">
                                                    <button type="button" class="btn btn-danger btn-sm"
                                                            onclick="if (confirm('Вы уверены?')) { this.form.submit() }">
                                                        <i class="fa fa-trash"></i>
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
