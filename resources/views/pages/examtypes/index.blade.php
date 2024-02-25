@extends('layouts.admin')

@section('content')
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Imtihon turlari</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('home') }}">Bosh sahifa</a></li>
                            <li class="breadcrumb-item active">Imtihon turlari </li>
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
                            @can('examtype.create')
                            <a href="{{ route('examtypes.create') }}" class="btn btn-success btn-sm float-right">
                            <span class="fas fa-plus-circle"></span>
                                Imtihon turlari  qo'shish
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
                                    <th>Imtihon turlari </th>
                                    <th>Amallar</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($examtypes as $examtype)
                                     <tr id="datas_ids{{ $examtype->id }}">
                                        <td>
                                            <div class="icheck-success">
                                                <input type="hidden" name="" id="delete_url" value="{{ route('examtypes.DeleteAll') }}">
                                                <input type="checkbox" class="checkbox_ids" name="ids" id="checkboxSuccess.{{$examtype->id}}" value="{{ $examtype->id }}">
                                                <label for="checkboxSuccess.{{$examtype->id}}" >
                                                </label>
                                            </div>
                                        </td>
                                        <td>{{ $examtype->id }}</td>
                                        <td>{{ $examtype->name }}</td>
                        
                                        <td class="text-center">
                                            @can('examtype.destroy')
                                            <form action="{{ route('examtypes.destroy',$examtype->id) }}" method="post">
                                                @csrf
                                                <div class="btn-group">
                                                    @can('examtype.edit')
                                                    <a href="{{ route('examtypes.edit',$examtype->id) }}" type="button" class="btn btn-info btn-sm"> Tahrirlash</a>
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
