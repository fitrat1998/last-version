@extends('layouts.admin')

@section('content')
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Darslik</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('home') }}">Bosh sahifa</a></li>
                            <li class="breadcrumb-item active">Darslik </li>
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
                            @can('exercise.create')
                            <a href="{{ route('exercises.create') }}" class="btn btn-success btn-sm float-right">
                            <span class="fas fa-plus-circle"></span>
                                Darslik  qo'shish
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
                                    <th>Mashg'ulot</th>
                                    <th>Guruh</th>
                                    <th>Xodim</th>
                                    <th>O'quv yili</th>
                                    <th>Semester</th>
                                    <th>Fan</th>
                                    <th>O'tilish vaqti</th>
                                    <th>Amallar</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($exercises as $e)
                                    <tr id="datas_ids{{ $e->id }}">
                                        <td>
                                            <div class="icheck-success">
                                                <input type="hidden" name="" id="delete_url" value="{{ route('exercises.DeleteAll') }}">
                                                <input type="checkbox" class="checkbox_ids" name="ids" id="checkboxSuccess.{{$e->id}}" value="{{ $e->id }}">
                                                <label for="checkboxSuccess.{{$e->id}}" >
                                                </label>
                                            </div>
                                        </td>
                                        <td>{{ $e->id }}</td>
                                        <td>{{ $e->title }}</td>
                                        <td>{{ $e->lessontype->name }}</td>
                                        <td>{{ $e->group->name }}</td>
                                        <td>{{ $e->teacher->fullname }} </td>
                                        <td>{{ $e->educationyear->education_year }} - yil</td>
                                        <td>{{ $e->semester->semester_number }} - semester</td>
                                        <td>{{ $e->subject->subject_name }} </td>
                                        <td>{{ $e->date }}</td>
                                        <td class="text-center">
                                            @can('exercise.destroy')
                                            <form action="{{ route('exercises.destroy',$e->id) }}" method="post">
                                                @csrf
                                                <div class="btn-group">
                                                    @can('exercise.edit')
                                                    <a href="{{ route('exercises.edit',$e->id) }}" type="button" class="btn btn-info btn-sm"> Tahrirlash</a>
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
