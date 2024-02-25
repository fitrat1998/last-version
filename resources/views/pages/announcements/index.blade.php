@extends('layouts.admin')

@section('content')
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>E'lonlar</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('home') }}">Bosh sahifa</a></li>
                            <li class="breadcrumb-item active">E'lon</li>
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
                            @can('announcement.create')
                            <a href="{{ route('announcements.create') }}" class="btn btn-success btn-sm float-right">
                            <span class="fas fa-plus-circle"></span>
                                Yangi e'lon qo'shish
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
                                    <th>Sarlavha</th>
                                    <th>Elonlar</th>
                                    <th>Yaratilgan vaqti</th>
                                    <th>Amallar</th>
                                </tr>
                                </thead>
                                <tbody>
                                    @if($announcements)
                                        @foreach($announcements as $announcement)
                                            <tr id="datas_ids{{ $announcement->id }}">
                                                <td>
                                                    <div class="icheck-success">
                                                        <input type="hidden" name="" id="delete_url" value="{{ route('announcements.DeleteAll') }}">
                                                        <input type="checkbox" class="checkbox_ids" name="ids" id="checkboxSuccess.{{$announcement->id}}" value="{{ $announcement->id }}">
                                                        <label for="checkboxSuccess.{{$announcement->id}}" >
                                                        </label>
                                                    </div>
                                                </td>
                                                <td>{{ $announcement->id }}</td>
                                                <td>{{ $announcement->title }}</td>
                                                <td>{{ $announcement->text }}</td>
                                                <td>{{ $announcement->created_at->format('d-m-Y') }}</td>

                                                <td class="text-center">
                                                    @can('announcement.destroy')
                                                        <form action="{{ route('announcements.destroy',$announcement->id) }}" method="post">
                                                            @csrf
                                                            <div class="btn-group">
                                                                @can('announcement.edit')
                                                                    <a href="{{ route('announcements.edit',$announcement->id) }}" type="button" class="btn btn-info btn-sm"> Tahrirlash</a>
                                                                @endcan
                                                                <input name="_method" type="hidden" value="DELETE">
                                                                <button type="button" class="btn btn-danger btn-sm" onclick="if (confirm('Вы уверены?')) { this.form.submit() } "> O'chirish</button>
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
