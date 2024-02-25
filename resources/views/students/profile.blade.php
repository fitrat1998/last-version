@extends('layouts.student-app')
@section('content')
    <!-- Main -->
    <main>
        <!-- Profile header for responsive -->
        <section class="main__header">
            <div>
                <a
                    href="/"
                    style="display: block;"
                    class="main__mobile--logo"
                >
                    <img class="logo" src="{{ asset('assets/images/logo.png') }}" alt="Logo" />
                </a>
            </div>

            <!-- Profile -->
            <div class="right__sider--head main__banner--profile">
                <button class="btn btn-text">
{{--                    <img--}}
{{--                        width="26"--}}
{{--                        src="{{ asset('assets/images/notif-icon.svg') }}"--}}
{{--                        alt="Notif icon"--}}
{{--                    />--}}
{{--                    <span class="main__badge">9</span>--}}
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
                    <li><a class="dropdown-item" href="#">Profile</a></li>
                </ul>
                <br>
            <hr>
            <div class="card m-5" style="width: 18rem;">
                <img class="card-img-top" src="{{ asset('assets/images/profile-image.png') }}" alt="Card image cap">
                <div class="card-body">
                    <h5 class="card-title">
                        <i class="fa fa-user"></i> {{ auth()->user()->name }}</h5><hr>
                </div>
                <form action="">
                    @csrf
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item">Fakultet nomi:<br /> {{ $faculty->faculty_name}}</li>
                        <li class="list-group-item">Yo'nalish nomi:<br /> {{ $programm->programm_name}}</li>
                        <li class="list-group-item">Guruh:<br />{{ $group->name}}</li>
{{--                        <li class="list-group-item"><input type="text" placeholder="Parol"> </li>--}}
{{--                        <li class="list-group-item"><input type="text" placeholder="Yangi parol"> </li>--}}
{{--                        <li class="list-group-item"><button class="btn btn-primary">Yangilash</button></li>--}}
                    </ul>
                </form>


                {{--            <div class="card-body">--}}
                {{--                <a href="#" class="card-link">Card link</a>--}}
                {{--                <a href="#" class="card-link">Another link</a>--}}
                {{--            </div>--}}
            </div>
            </div>
        </section>

    </main>
@endsection
