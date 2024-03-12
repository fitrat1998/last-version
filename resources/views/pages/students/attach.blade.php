@extends('layouts.admin')

@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Talaba</h1>
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
        <form action="{{ route('attachstudents.store') }}" method="post" enctype="multipart/form-data">
            @csrf
            <div class="row">
                <div class="col-8">
                    <div class="card">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="card-body w-60" style="overflow:auto">
                                    <div class="form-group">
                                        <label>Mutaxassislik</label><br/>
                                        <select class="form-control w-50 select2" name="programms_id" id="programm">
                                            <option value="">Mutaxassislikni tanlang</option>
                                            @foreach ($programms as $programm)
                                                <option value="{{ $programm->id }}">{{ $programm->programm_name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <!-- Data table -->
                                    <table id="AttachStudent"
                                           class="table table-bordered table-striped dataTable dtr-inline table-responsive-lg"
                                           user="grid" aria-describedby="dataTable_info">
                                        <thead>
                                        <tr>
                                            <th><i class="fa fa-check"></i></th>
                                            <th>ID</th>
                                            <th>Fish</th>
                                            <th>Yo'nalish</th>
                                        </tr>
                                        </thead>
                                        <tbody>

                                        <tr>
                                            <td>
                                                <div class="icheck-success d-inline">
                                                    <input type="checkbox" id="student" name="students_id">
                                                    <label for="student">
                                                    </label>
                                                </div>
                                            </td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                        </tr>

                                        </tbody>
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
                                <label>Fakultet</label><br/>
                                <select class="form-control select2" name="faculties_id" id="faculties_id">
                                    <option value="">Fakultetni tanlang</option>
                                    @foreach ($faculties as $faculty)
                                        <option value="{{ $faculty->id }}">{{ $faculty->faculty_name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group">
                                <label>Ta'lim turi</label><br/>
                                <select class="form-control select2" name="educationtypes_id" id="educationtypes_id">
                                    <option value="">Ta'lim turi tanlang</option>
                                    @foreach ($educationtypes as $educationtype)
                                        <option value="{{ $educationtype->id }}">
                                            {{ $educationtype->education_type }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label>O'quv yili</label><br/>
                                <select class="form-control select2" name="educationyears_id" id="educationyears_id">
                                    <option value="">O'quv yilini tanlang</option>
                                    @foreach ($educationyears as $educationyear)
                                        <option value="{{ $educationyear->id }}">
                                            {{ $educationyear->education_year }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Guruh</label><br/>
                                <select class="form-control select2" name="groups_id" id="groups_id">
                                    <option value="">Guruhni tanlang</option>
                                    @foreach ($groups as $group)
                                        <option value="{{ $group->id }}">{{ $group->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Semester</label><br/>
                                <select class="form-control select2" name="semesters_id" id="semesters_id">
                                    <option value="">Semesterni tanlang</option>
                                    @foreach ($semesters as $semester)
                                        <option value="{{ $semester->id }}">{{ $semester->semester_number }}</option>
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
