@extends('layouts.student-app')

@section('content')
    <section class="main__header">
        <div>
            <a
                href="/"
                style="display: block;"
                class="main__mobile--logo"
            >
                <img class="logo" src="{{ asset('assets/images/logo.png') }}" alt="Logo"/>
            </a>
        </div>

        <!-- Profile -->
        <div class="right__sider--head main__banner--profile">
            <button class="btn btn-text">
                <img
                    width="26"
                    src="{{ asset('assets/images/notif-icon.svg') }}"
                    alt="Notif icon"
                />
                <span class="main__badge">9</span>
            </button>
            <button
                type="button"
                class="btn btn-text dropdown-toggle mobileHide"
                data-bs-toggle="dropdown"
                aria-expanded="false"
            >
                <img
                    class="profile__small--image"
                    src="{{ asset('assets/images/profile-image.png') }}"
                    alt="Profile"
                />
                Toshmat
            </button>
            <ul class="dropdown-menu">
                <li><a class="dropdown-item" href="#">Profile</a></li>
            </ul>
        </div>
    </section>

    <section>
        <h1 class="text-center text-muted m-2">Umumiy natijalar</h1>
        <div class="card p-1">
            <table id="example" class="table table-striped table-responsive" style="width:100%">
                <thead>
                <tr>
                    <th>Fan</th>
                    <th>Test turi</th>
                    <th>Ball</th>
                    <th>Mavzular</th>
                    <th>Holati</th>
                </tr>
                </thead>
                <tbody>
                @foreach($results as $result)
                    <tr>
                        <td>
                            @if($result)
                                {{$result->subject($result->subjects_id)}}
                            @else
                                mavjud emas
                            @endif
                        </td>

                        <td>
                            @if($result)
                                {{$result->examtype($result->examtypes_id)->name}}
                            @else
                                mavjud emas
                            @endif
                        </td>

                        <td>
                            @if($result)
                                {{$result->ball ?? 0}} / {{$result->correct ?? 0}}
                            @else
                                mavjud emas
                            @endif
                        </td>

                        <td>
                            @foreach($result->examps() as $r)
                                <span class="bg-primary text-white p-1" style="border-radius: 7px;">{{ $r }}</span>
                            @endforeach
                        </td>

                        <td>
                            @php
                                if($result->ball > 0){
                                      $status = $result->ball / ($result->correct + $result->incorrect);
                                }
                                $passing = $result->examtypes($result->examtypes_id,$result->subjects_id);
                            @endphp

                            @if($result->ball ?? 0 > $passing->passing ?? 1)
                                <span class="text-success">Muvaffaqiyatli yakunlandi</span>
                            @else
                                <span class="text-danger">Muvaffaqiyatsiz yakunlandi</span>
                            @endif


                        </td>
                    </tr>
                @endforeach
                </tbody>
                <tfoot>
                <tr>
                    @php
                        $sum_final = 0;
                        $sum_retry = 0;
                        $sum_selfstudy = 0;
                        $sum_middle = 0;
                        foreach($results as $r){

                            if($r->examtypes_id == 1){
                                $sum_middle += $r->ball;
                            }

                            if($r->examtypes_id == 2){
                                $sum_selfstudy += $r->ball;
                            }

                            if($r->examtypes_id == 3){
                                $sum_retry += $r->ball;
                            }

                            if($r->examtypes_id == 4){
                                $sum_final += $r->ball;
                            }
                        }
                    @endphp
                    <th colspan="2" style="text-align:right">
                        {{--                        <span class="mr-3">Oraliq umumiy: {{$sum_middle}}</span>--}}
                        {{--                        <span class="mr-3">Mustaqil ta'lim umumiy: {{$sum_selfstudy}}</span>--}}
                        {{--                        <span class="mr-3">Oraliq umumiy: {{$sum_retry}}</span>--}}
                        {{--                        <span class="mr-3">Yakuniy umumiy: {{$sum_final}}  </span>--}}
{{--                        Umimuyi ball: {{ $sum_middle + $sum_selfstudy }}--}}
                    </th>
                    <th></th>
                    <th></th>

                </tr>
                </tfoot>


            </table>


        </div>
    </section>
@endsection
