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
                                        <h4>Davomat vaqti: <span> {{ date('Y/m/d') }} </span></h4>
                                    </div>
                                    <div class="card-body">
                                        <table class="table table-bordered">
                                            <thead>
                                                <tr>
                                                    <th style="width: 20px" class="text-center text-success"><i class="fa fa-check"></i></th>
                                                    <th>Talaba</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td class="">
                                                        <div class="col-sm-6">
                                                            <div class="form-group clearfix">
                                                                <div class="icheck-primary d-inline">
                                                                    <input type="radio" id="checkboxSuccess2" class="p-3" style="border-radius: 50%;">
                                                                    <label for="checkboxSuccess2">
                                                                    </label>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td>Shoyim Obloqulov</td>
                                                </tr>
                                            </tbody>
                                        </table>
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
