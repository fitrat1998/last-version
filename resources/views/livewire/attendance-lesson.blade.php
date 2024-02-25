    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-12">
                    <h1>Darslar</h1>
                </div>
                <div class="col-sm-12">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}">Bosh sahiha</a></li>
                        <li class="breadcrumb-item active">Darslar</li>
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
                        <h3 class="card-title">Darslar</h3>
                        @can('attendance_log.add')
                            <a href="{{ route('attendance_logs.create') }}" class="btn btn-success btn-sm float-right">
                                <span class="fas fa-plus-circle"></span>
                                Qo'shish
                            </a>
                        @endcan
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body w-100" style="overflow:auto">
                        <!-- Data table -->
                        <table id="dataTable"
                            class="table table-bordered table-striped dataTable dtr-inline table-responsive-lg"
                            user="grid" aria-describedby="dataTable_info">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Guruh</th>
                                    <th>Fan</th>
                                    <th>Mavzu</th>
                                    <th>Dars sanasi</th>
                                    <th>Davomat</th>
                                    <th class="w-25">Amallar</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($attendance_logs as $attendance_log)
                                    <tr>
                                        <td>{{ $attendance_log->id }}</td>

                                        @if ($attendance_log->group_id)
                                            <td>{{ $groups->find($attendance_log->group_id)->group_number }}</td>
                                        @else
                                            <td>mavjud emas</td>
                                        @endif

                                        @if ($attendance_log->subject_id)
                                            <td>{{ $subjects->find($attendance_log->subject_id)->subject_name }}</td>
                                        @else
                                            <td>mavjud emas</td>
                                        @endif
                                        
                                        <td>
                                             @can('attendance_log.edit')
                                                <a href="{{ route('attendance_logs.show', $attendance_log->id) }}" type="button"
                                                    class="btn btn-success btn-sm w-100"><i class="fa-solid fa-link"></i> O'tish </a>
                                            @endcan
                                        </td>
                                        <td class="text-center">
                                            @can('attendance_log.delete')
                                                <form action="{{ route('attendance_logs.destroy', $attendance_log->id) }}" method="post">
                                                    @csrf
                                                    <div class="btn-group">
                                                        @can('attendance_log.edit')
                                                            <a href="{{ route('attendance_logs.edit', $attendance_log->id) }}" type="button"
                                                                class="btn btn-info btn-sm">Tahrirlash</a>
                                                        @endcan
                                                        <input name="_method" type="hidden" value="DELETE">
                                                        <button type="button" class="btn btn-danger btn-sm"
                                                            onclick="if (confirm('Вы уверены?')) { this.form.submit() } ">O'chirish</button>
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