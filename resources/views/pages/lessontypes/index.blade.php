@extends('layouts.admin')

@section('content')
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Dars turlari</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('home') }}">Bosh sahifa</a></li>
                            <li class="breadcrumb-item active">Dars turlari </li>
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
                            <h3 class="card-title">Dars turlari </h3>
                            @can('lessontypes.create')
                            <a href="{{ route('lessontypes.create') }}" class="btn btn-success btn-sm float-right">
                            <span class="fas fa-plus-circle"></span>
                                Dars turlari  qo'shish
                            </a>
                            @endcan
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <!-- Data table -->
                            <table id="dataTable" class="table table-bordered table-striped dataTable dtr-inline table-responsive-lg" user="grid" aria-describedby="dataTable_info">
                                <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Dars turlari </th>
                                    <th>Amallar</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($lessontypes as $lessontype)
                                    <tr>
                                        <td>{{ $lessontype->id }}</td>
                                        <td>{{ $lessontype->name }}</td>
                        
                                        <td class="text-center">
                                            @can('lessontype.destroy')
                                            <form action="{{ route('lessontypes.destroy',$lessontype->id) }}" method="post">
                                                @csrf
                                                <div class="btn-group">
                                                    @can('lessontype.edit')
                                                    <a href="{{ route('lessontypes.edit',$lessontype->id) }}" type="button" class="btn btn-info btn-sm"> Tahrirlash</a>
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
