@extends('layouts.student-app')

@section('content')
    <!-- Profile header for responsive -->
    <section class="main__header">
        <div>
            <a href="./index.html" style="display: block" class="main__mobile--logo">
                <img class="logo" src="./assets/images/logo.png" alt="Logo" />
            </a>
        </div>

        <!-- Profile -->
        <div class="right__sider--head main__banner--profile">
            <button class="btn btn-text">
                <img width="26" src="./assets/images/notif-icon.svg" alt="Notif icon" />
                <span class="main__badge">9</span>
            </button>
            <button type="button" class="btn btn-text dropdown-toggle mobileHide" data-bs-toggle="dropdown"
                aria-expanded="false">
                <img class="profile__small--image" src="./assets/images/profile-image.jpg" alt="Profile" />
                Toshmat
            </button>
            <ul class="dropdown-menu">
                <li><a class="dropdown-item" href="#">Profile</a></li>
            </ul>
        </div>
    </section>

    <!-- Banner -->
    <section class="banner">
        <div>
{{--             @foreach($announcements as $announcement)--}}
            <h1 class="">
{{--                {{$announcements}}--}}
            </h1>
{{--            @endforeach--}}
        </div>
        <div class="banner__image">
            <img src="./assets//images/banner-image.png" alt="Banner" />
        </div>
    </section>

    <!-- Slider -->
        <section>
            <h3 class="section__title">Fanlar</h3>
            <div class="splide" aria-label="Splide Basic HTML Example">
            <div class="splide__track">
                <ul class="splide__list">
                <li class="splide__slide">
                    <div class="slider__list--item">
                    <div class="slider__list--body">
                        <div class="slider__list--icon">
                        <img
                            src="./assets/images/math-icon.svg"
                            alt="Math icon"
                        />
                        </div>
                        <div>
                        <h4 class="slider__list--title">Matematika</h4>
                        <p class="slider__list--text">O'qituvchi nomi</p>
                        </div>
                    </div>
                    </div>
                </li>
                <li class="splide__slide">
                    <div class="slider__list--item">
                    <div class="slider__list--body">
                        <div class="slider__list--icon">
                        <img
                            src="./assets/images/chemistry-icon.svg"
                            alt="Math icon"
                        />
                        </div>
                        <div>
                        <h4 class="slider__list--title">Kimyo</h4>
                        <p class="slider__list--text">O'qituvchi nomi</p>
                        </div>
                    </div>
                    </div>
                </li>
                <li class="splide__slide">
                    <div class="slider__list--item">
                    <div class="slider__list--body">
                        <div class="slider__list--icon">
                        <img
                            src="./assets/images/geometry-icon.svg"
                            alt="Math icon"
                        />
                        </div>
                        <div>
                        <h4 class="slider__list--title">Geometriya</h4>
                        <p class="slider__list--text">O'qituvchi nomi</p>
                        </div>
                    </div>
                    </div>
                </li>
                </ul>
            </div>
            </div>
        </section>
@endsection
