@extends('layouts.student-app')

@section('content')
    <section class="main__header">
        <div>
            <a
                href="{{ route('studentAdminIndex') }}"
                style="display: block;"
                class="main__mobile--logo"
            >
                <img class="logo" src="{{ asset('assets/images/logo.png') }}" alt="Logo"/>
            </a>
        </div>

        <!-- Profile -->
        <div class="right__sider--head main__banner--profile">
            <button class="btn btn-text">
                <a href="{{ route('StudentProfile') }}">
                    <i class="fa-solid fa-circle-user bar__icon"></i>
                </a>
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
            </button>
            <ul class="dropdown-menu">
                <li><a class="dropdown-item" href="{{ route('studentAdminIndex') }}">Profile</a></li>
            </ul>
        </div>
    </section>
    <section class="banner">

        <!-- Slider -->
        <div class="splide w-100" aria-label="Splide Basic HTML Example" id="headerSlider">
            <div class="splide__track">
                <ul class="splide__list">
                    @foreach($announcements as $announcement)
                        <li class="splide__slide">
                            <h3 style="color:#fff">{{ $announcement->title }}</h3>
                            <div style="height: 120px">
                                <p class="banner__title">
                                    {{ $announcement->text }}
                                </p>
                            </div>
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>
        <div class="banner__image">
            <img src="{{asset("./assets/images/banner-image.png")}}" alt="Banner"/>
        </div>
    </section>

    <section>
        <h3 class="section__title">Fanlar</h3>
        <div class="splide" aria-label="Splide Basic HTML Example" id="subjectSlider">
            <div class="splide__track">
                <ul class="splide__list">
                    @foreach($subjects as $subject)
                        <li class="splide__slide">
                            <div class="slider__list--item">
                                <div class="slider__list--body">
                                    <div class="slider__list--icon">
                                        <img
                                            src="{{asset('assets/images/math-icon.svg')}}"
                                            alt="Math icon"
                                        />
                                    </div>
                                    <div>
                                        <h4 class="slider__list--title">{{ $subject->subject_name }}</h4>
                                        {{--                                        <p class="slider__list--text">O'qituvchi nomi</p>--}}
                                    </div>
                                </div>
                            </div>
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>
        <div class="card p-1">
            <table id="example" class="table table-striped table-responsive" style="width:100%">
                <thead>
                <tr>
                    <th>Fan</th>
                    <th>Test turi</th>
                    <th>Ball</th>
                    <th>Sanasi</th>
                    <th>Holati</th>
                </tr>
                </thead>
                <tbody>

                @foreach($results as $result)

                    @php

                        $passing = $result->examtypes($result->quizzes_id,$result->subjects_id);
                    @endphp
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
                                {{$result->ball / 10 ?? 0}}
                            @else
                                mavjud emas
                            @endif
                        </td>

                        <td>
                            @if($result)
                                {{$result->created_at->format('Y-m-d')}}
                            @else
                                mavjud emas
                            @endif
                        </td>

                        <td>
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
                        $sum_current = 0;
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

                            if($r->examtypes_id == 5){
                                $sum_current += $r->ball;
                            }
                        }
                    @endphp
                    <th colspan="2" style="text-align:right">
                        {{--                        <span class="mr-3">Oraliq umumiy: {{$sum_middle}}</span>--}}
                        {{--                        <span class="mr-3">Mustaqil ta'lim umumiy: {{$sum_selfstudy}}</span>--}}
                        {{--                        <span class="mr-3">Oraliq umumiy: {{$sum_retry}}</span>--}}
                        {{--                        <span class="mr-3">Yakuniy umumiy: {{$sum_final}}  </span>--}}
                        Umimuyi ball: {{ $sum_middle + $sum_selfstudy +  $sum_current / 10}}
                    </th>
                    <th></th>
                    <th></th>

                </tr>
                </tfoot>


            </table>


        </div>
    </section>
@endsection
