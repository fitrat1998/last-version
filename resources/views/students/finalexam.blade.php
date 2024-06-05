
@extends('layouts.student-app')

@section('content')
    <section class="main__header">
        <div class="d-flex align-items-center gap-2" style="width: 70%">
            <a
                href="/"
                style="display: block"
                class="main__mobile--logo"
            >
                <img class="logo" src="{{ asset('assets/images/logo.png') }}" alt="Logo" />
            </a>
            <h3 class="section__title mx-lg-0 mx-auto">Yakuniy</h3>
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
                Toshmat
            </button>
            <ul class="dropdown-menu">
                <li><a class="dropdown-item" href="#">Profile</a></li>
            </ul>
        </div>
    </section>

    <section class="row m-0">
        @foreach( $finalexams as $all)
            @foreach($all as $f)
            <livewire:finalexams :f="$f" />
            @endforeach
        @endforeach
    </section>
@endsection
