@extends('layouts.admin')

@section('content')

    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Guruh</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}">Bosh sahifa</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('programmIndex') }}">Yo'nalishlar</a></li>
                        <li class="breadcrumb-item active">Qo'shish</li>
                    </ol>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>
    <!-- Main content -->

    <section class="content">
        <div class="row">
            <div class="col-lg-8 offset-lg-2 col-sm-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Yangi yo'nalish qo'shish</h3>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">

                        <form action="{{ route('programmCreate') }}" method="post">
                            @csrf
                            <div class="form-group">
                                <label>Fakultet</label><br />
                                <select class="form-control select2" name="faculty_id" id="faculty_id">
                                    <option value="">fakultetni tanlang</option>
                                    @foreach($faculties as $faculty)
                                    <option value = "{{ $faculty->id }}" >{{ $faculty->faculty_name }}</option>
                                    @endforeach
                                </select>
                                
                            </div>
                            <div class="form-group">
                                <label>Yo'nalish</label>
                                <input type="text" name="programm" class="form-control {{ $errors->has('name') ? "is-invalid":"" }}" value="{{ old('name') }}" required>
                                @if($errors->has('name'))
                                    <span class="error invalid-feedback">{{ $errors->first('name') }}</span>
                                @endif
                            </div>
                            <div class="form-group">
                                <button type="submit" class="btn btn-success float-right">Saqlash</button>
                                <a href="{{ route('programmIndex') }}" class="btn btn-default float-left">Bekor qilish</a>
                            </div>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </section>

@endsection
