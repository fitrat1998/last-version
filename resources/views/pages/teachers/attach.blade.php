@extends('layouts.admin')

@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>O'qitvchi</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}">Bo'sh sahifa</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('attachstudents.index') }}">Talabalar</a></li>
                        <li class="breadcrumb-item active">Biriktirish</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>
    <section class="content">
        <form action="{{ route('attachteachers.store') }}" method="post" enctype="multipart/form-data">
            @csrf
            <div class="row">
                <div class="col-8">
                    <div class="card">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="card-body w-60" style="overflow:auto">
                                    <div class="form-group">
                                        <label>Mutaxassislik</label><br />
                                        <select class="form-control w-50 select2" name="faculty_id" id="faculty">
                                            <option value="">Fakultetni tanlang</option>
                                            @foreach ($faculties as $faculty)
                                                <option value = "{{ $faculty->id }}">{{ $faculty->faculty_name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <!-- Data table -->
                                    <table id="teachersTable"
                                        class="table table-bordered table-striped dataTable dtr-inline table-responsive-lg"
                                        aria-describedby="dataTable_info">
                                        <thead>
                                            <tr>
                                                <th><i class="fa fa-check"></i></th>
                                                <th>ID</th>
                                                <th>Fish</th>
                                                <th>Fakultet</th>
                                            </tr>
                                        </thead>
                                        <td>
                                            <div class="icheck-success d-inline">
                                                <input type="checkbox"  id="student" name="students_id">
                                                <label for="student">
                                                </label>
                                            </div>
                                        </td>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-4">
                    <div class="card">
                        <div class="card-body"></div>
                        <div class="card-header">

                            <div class="form-group">
                                <label>Guruh</label><br />
                                <select class="form-control select2" name="groups_id" id="groups_id">
                                    <option value="">Guruhni tanlang</option>
                                    @foreach ($groups as $group)
                                        <option value = "{{ $group->id }}">{{ $group->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group">
                                <button type="submit" class="btn btn-success float-right">Saqlash</button>
                                <a href="{{ route('studentIndex') }}" class="btn btn-default float-left">Bekor
                                    qilish</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </section>
@endsection
