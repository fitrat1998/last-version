@extends('layouts.admin')

@section('content') 

    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Yo'nalishlar</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}">Bosh sahifa</a></li>
                        <li class="breadcrumb-item active">Yo'nalishlar</li>
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
                        @can('programm.create')
                            <a href="{{ route('programmAdd') }}" class="btn btn-success btn-sm float-right">
                                <span class="fas fa-plus-circle"></span>
                                Yo'nalish qo'shish
                            </a>
                            <a href="" class="btn btn-danger" id="deleteAllSellected"> O'chirish</a>
                        @endcan
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <!-- Data table -->
                        <table id="dataTable"
                               class="table table-bordered table-striped dataTable dtr-inline table-responsive-lg"
                               user="grid" aria-describedby="dataTable_info">
                            <thead>
                            <tr>
                                <th>
                                    <div class="icheck-success">
                                        <input type="checkbox" name="" id="select_all_ids">
                                        <label for="select_all_ids" ></label>
                                    </div>
                                </th>
                                <th>ID</th>
                                <th>Yo'nalish</th>
                                <th>Fakultet</th>
                                <th>Amallar</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($programms as $programm)
                                <tr id="datas_ids{{ $programm->id }}">
                                    <td>
                                        <div class="icheck-success">
                                            <input type="hidden" name="" id="delete_url" value="{{ route('programmDeleteAll') }}">
                                            <input type="checkbox" class="checkbox_ids" name="ids" id="checkboxSuccess.{{$programm->id}}" value="{{ $programm->id }}">
                                            <label for="checkboxSuccess.{{$programm->id}}" >
                                            </label>
                                        </div>
                                    </td>
                                    <td>{{ $programm->id }}</td>
                                    <td>{{ $programm->programm_name }}</td>
                                    <td>{{ $programm->faculty->faculty_name }}</td>
                                    <td class="text-center">
                                        @can('programm.destroy')
                                            <form id="deleteForm" action="{{ route('programmDestroy', $programm->id) }}"
                                                  method="post">
                                                @csrf
                                                <div class="btn-group">
                                                    @can('programm.edit')
                                                        <a href="{{ route('programmEdit', $programm->id) }}"
                                                           type="button" class="btn btn-info btn-sm"> Tahrirlash</a>
                                                    @endcan
                                                    <input name="_method" type="hidden" value="DELETE">
                                                        <button type="button" class="btn btn-danger btn-sm"
                                                            onclick="if (confirm('Вы уверены?')) { this.form.submit() } "> <i class="fa fa-trash"></i>
                                                        </button>

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

@section('scripts')
  <!--  <script>
        $(function(e){

            $('#select_all_ids').click(function(){
                $('.checkbox_ids').prop('checked',$(this).prop('checked'));
            });

            var csrf_token = "{{ csrf_token() }}"

            $('#deleteAllSellected').click(function(e){
                e.preventDefault();
                const all_ids = [];
                $('input:checkbox[name=ids]:checked').each(function(){
                    all_ids.push($(this).val());
                });

                const swalWithBootstrapButtons = Swal.mixin({
                  customClass: {
                    confirmButton: "btn btn-success",
                    cancelButton: "btn btn-danger"
                  },
                  buttonsStyling: false
                });
                swalWithBootstrapButtons.fire({
                  title: "Ishonchingiz komilmi 😳?",
                  text: "Diqqat o'chirilgan malumotlar qayta tiklanmasligi mumkin",
                  icon: "warning",
                  showCancelButton: true,
                  confirmButtonText: "O'chirish",
                  cancelButtonText: "Bekor qilish!",
                  reverseButtons: true
                }).then((result) => {
                  if (result.isConfirmed) {
                         $.ajax({
                            // url: "{{ route('programmDeleteAll') }}",
                            type: 'DELETE',
                            data: {
                                ids: all_ids,
                                _token: csrf_token
                            },
                            success: function(response) {
                                console.log('response', response)
                                if(response.success == true){
                                    $.each(all_ids, function(key, val) {
                                        $('#programm_ids' + val).remove();   
                                    });
                                    swalWithBootstrapButtons.fire({
                                      title: "O'chirildi!",
                                      text: "Malumotlar muvaffaqiyatli o'chirildi! 😇",
                                      icon: "success"
                                    });

                                }else {
                                    alert(response.message)
                                }
                                
                            }
                        });
                  } 
                  else if (
                    /* Read more about handling dismissals below */
                    result.dismiss === Swal.DismissReason.cancel
                  ) {
                    swalWithBootstrapButtons.fire({
                      title: "Jarayon bekor qilindi 🙂",
                      text: "Xavotirlanmang malumotlaringiz o'z joyida 🫠",
                      icon: "error"
                    });
                  }
                });

            });

        });
    </script> -->
@endsection
