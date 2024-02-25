    @extends('layouts.admin')

    @section('content')
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">

            </div>
        </section>
        <!-- Main content -->
        <section class="content">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <section class="content">
                            <div class="container-fluid">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="card-header">
                                            <h4>Davomat vaqti: <span> {{ date('Y/m/d') }} </span> -- <span class="text-warning">{{ $exercise->title}}</span></h4>
                                        </div>
                                        <div class="card-body">
                                            <table class="table table-bordered">
                                                <thead>
                                                    <tr>
                                                        <th style="width: 20px" class="text-center text-success"><i class="fa fa-check"></i></th>
                                                        <th w-25    >Talaba</th>
                                                        <th style="width: 20px">Holati</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                <form action="{{ route('attendancechecks.store') }}" method="post" enctype="multipart/form-data">
                                                    @csrf
                                                     @php
                                                        $now = $now->format('Y-m-d');
                                                     @endphp
                                                       @if($exercise)
                                                            @php
                                                                $now = \Carbon\Carbon::parse()->format('Y-m-d');
                                                                $exercise_time = \Carbon\Carbon::parse($exercise->created_at)->format('Y-m-d');
                                                            @endphp
                                                        @else

                                                      @php
                                                        $exercise_time = 0;
                                                      @endphp
                                                    @endif

                                                   @if(!empty($students))
                                                    @foreach($students as $student)
                                                    @php
                                                        if(!empty($status)){

                                                            $attendanceStatus = $status->contains('students_id', $student['id']);
                                                        }
                                                        else {
                                                            $attendanceStatus = "dafda";
                                                        }
                                                    @endphp
                                                    <tr>
                                                        <td class="">
                                                            @if($attendanceStatus)
                                                                <div class="col-sm-6">
                                                                    <div class="form-group clearfix">
                                                                        <div class="icheck-primary d-inline">
                                                                            <input type="checkbox" name="students_id[]" 
                                                                             id="checkboxSuccess{{ $student['id'] }}" class="p-3" style="border-radius: 50%;" disabled>
                                                                            <label for="checkboxSuccess{{ $student['id'] }}">
                                                                            </label>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                           @else
                                                            <div class="col-sm-6">
                                                                <div class="form-group clearfix">
                                                                    <div class="icheck-primary d-inline">
                                                                        <input type="checkbox" name="students_id[]" 
                                                                         id="checkboxSuccess{{ $student['id'] }}" class="p-3" style="border-radius: 50%;" value="{{ $student['id'] }}">
                                                                        <label for="checkboxSuccess{{ $student['id'] }}">
                                                                        </label>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            @endif
                                                            <input type="hidden" name="exercise_id" value="{{ $exercise['id'] }}">
                                                        </td>
                                                        <td>{{ $student['fullname'] }}</td>
                                                        <td>
                                                            
                                                        @if ($attendanceStatus)
                                                            <p  class="text-center text-danger"><i class="fa fa-cancel"></i></p>
                                                        @else
                                                            <p  class="text-center text-success"><i class="fa-regular fa-square-check"></i></p>
                                                        @endif
                                                            
                                                        </td>
                                                    </tr>
                                                     
                                                    @endforeach
                                                 @else
                                                    
                                                    <tr>
                                                        <td class="">
                                            
                                                                <div class="col-sm-6">
                                                                    <div class="form-group clearfix">
                                                                        <div class="icheck-primary d-inline">
                                                                            <input type="checkbox" name="students_id[]" 
                                                                             id="checkboxSuccess{{ $student['id'] }}" class="p-3" style="border-radius: 50%;" disabled>
                                                                            <label for="checkboxSuccess{{ $student['id'] }}">
                                                                            </label>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            
                                                            
                                                            
                                                            <input type="hidden" name="exercise_id" value="{{ $exercise['id'] }}">
                                                        </td>
                                                        
                                                        <td>
                                                            
                                                      
                                                            
                                                        </td>
                                                    </tr>
                                                    @endif

                                                </tbody>

                                            </table>
                                            @if($now == $exercise_time)
                                                <div class="form-group p-1">
                                                    <button type="submit" class="btn btn-success float-left">Saqlash</button>
                                                    <a href="{{ route('attendancechecks.index') }}" class="btn btn-danger float-right">Bekor
                                                        qilish</a>
                                                </div>
                                            @endif
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </section>
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
