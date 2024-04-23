@extends('layouts.admin')
@section('content')
         <!-- Content Header (Page header) -->
         <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Savollar</h1>
                        @if(session('success'))
                            <div class="alert alert-success">
                                {{ session('success') }}
                            </div>
                        @endif
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('home') }}">Bosh sahifa</a></li>
                            <li class="breadcrumb-item active">Savollar</li>
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
                            @can('question.create')
                            <a href="{{ route('questions.create')}}" class="btn btn-success btn-sm float-right">
                            <span class="fas fa-plus-circle"></span>
                                Savol qo'shish
                            </a>
                            @endcan
                        @can('question.destroy')
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
                                        <th class="w-50">Savol</th>
                                        <th>Mavzu</th>
                                        <th>Variantlar</th>
                                        <th>To'g'ri javoblar</th>
                                        <th class="w-25">Qiyinchiligi</th>
                                        <th class="w-25">Amallar</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @if(!is_null($questions))
                                    @foreach($questions as $question)
                                         <tr id="datas_ids{{ $question->id }}">
                                            <td>
                                                <div class="icheck-success">
                                                    <input type="hidden" name="" id="delete_url" value="{{ route('questions.DeleteAll') }}">
                                                    <input type="checkbox" class="checkbox_ids" name="ids" id="checkboxSuccess.{{$question->id}}" value="{{ $question->id }}">
                                                    <label for="checkboxSuccess.{{$question->id}}" >
                                                    </label>
                                                </div>
                                            </td>
                                            <td>{{ $question->id }}</td>
                                            <td>{{ $question->question }}</td>
                                            <td>{{ $question->topic->topic_name ?? "Mavjud emas" }}</td>
                                            <td>
                                                @foreach ($question->options as $key => $o)
                                                    <span class="badge bg-success">{{ chr($key + 65) }} - {{ $o->option }}</span>
                                                @endforeach
                                            </td>
                                            <td>
                                                @php
                                                    $s = 0;
                                                @endphp
                                                @foreach ($question->options as $key => $o)
                                                    @if ($o->is_correct == 1)
                                                        <span class="badge bg-success"> {{ chr($key + 65) }}</span>
                                                    @endif
                                                @endforeach
                                            </td>
                                            <td>
                                                 @foreach ($question->options as $key => $o)
                                                    <span class="badge bg-info">{{ chr($key + 65) }} - {{ $o->difficulty }}</span> <br>
                                                @endforeach
                                            </td>
                                            <td class="text-center">
                                                @can('question.destroy')
                                                <form action="{{ route('questions.destroy',$question->id) }}" method="post">
                                                    @csrf
                                                    <div class="btn-group">
                                                        @can('question.edit')
                                                            <a href="{{ route('questions.edit',$question->id) }}" type="button" class="btn btn-info btn-sm"> <i class="fa fa-edit"></i></a>
                                                        @endcan
                                                        <input name="_method" type="hidden" value="DELETE">
                                                        <button type="button" class="btn btn-danger btn-sm" onclick="if (confirm('Вы уверены?')) { this.form.submit() } "> <i class="fa fa-trash"></i></button>
                                                    </div>
                                                </form>
                                                @endcan
                                            </td>
                                        </tr>
                                    @endforeach
                                    @else
                                        <tr>
                                            <td>
                                                Savollar mavjud emas
                                            </td>
                                        </tr>
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
