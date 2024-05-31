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
            <button
                type="button"
                class="btn btn-text dropdown-toggle"
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
                <li><a class="dropdown-item" href="{{ route('StudentProfile') }}">
                        <i class="fa fa-user"></i>
                        Profile
                    </a></li>
                <li>
                    <form action={{ route('logout') }} method='POST'>
                        @csrf
                        <button class="dropdown-item text-danger" type="submit">
                            <i class="fa fa-sign-out-alt"></i>
                            Chiqish
                        </button>
                    </form>
                </li>
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
{{--        <div class="card mb-2">--}}
{{--            <div class="card-body">--}}
{{--                <div class="row">--}}
{{--                    <div class="col-md-4">--}}
{{--                        <div class="form-group">--}}
{{--                            <label for="fan">Fanlar </label>--}}
{{--                            <label>--}}
{{--                                <select class="select2 m-3 p-3 form-control" onchange="subjects()" id="subject_id">--}}
{{--                                    <option selected disabled>-- Tanlang --</option>--}}

{{--                                    @foreach($subjects as $s)--}}
{{--                                        <option value="{{ $s->id }}" @if($s->id == request()->get('subject')) selected @endif>{{ $s->subject_name }}</option>--}}
{{--                                    @endforeach--}}
{{--                                </select>--}}
{{--                            </label>--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--            </div>--}}
{{--        </div>--}}

        <div class="card p-1">
            <table id="example" class="table table-striped table-responsive" style="width:100%">
                <thead>
                <tr>
                    <th>Fanlar</th>
                    <th>J.N</th>
                    <th>M.I</th>
                    <th>O.R</th>
                    <th>Y.N</th>
                </tr>
                </thead>
                <tbody>
                @foreach($subjects as $s)
                    <tr>
                        <td>{{ $s->subject_name }}</td>
                        <td>{{ $s->jn() }}</td>
                        <td>{{ $s->mi() }}</td>
                        <td>{{ $s->onr() }}</td>
                        <td>{{ $s->yn() }}</td>
                    </tr>
                @endforeach

                </tbody>
            </table>
        </div>

    </section>
@endsection
