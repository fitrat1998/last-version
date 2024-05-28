<!DOCTYPE html>

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Universitet - Student</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" />
    <meta name="description" content="Quiz Student App" />
    <!-- Icon -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css" />
    <link rel="stylesheet" href="{{ asset('assets/css/main.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/css/exam.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/css/splide/splide.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/css/splide/themes/splide-default.min.css') }}" />
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/dataTables.bootstrap5.min.css" />
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

    @livewireStyles

</head>

<body>
    @if (Route::has('login'))
        @auth
            <!-- Sider -->
            <div class="sider show" id="sider">
                <!-- Head -->
                <div class="sider__head">
                    <a href="/" style="display: block">
                        <img class="logo" src="{{ asset('assets/images/logo.png') }}" alt="Logo" />
                    </a>
                    <!-- Humburger -->
                    <button class="btn btn-text sider__humberger" id="humburger">
                        <i class="fa-solid fa-bars"></i>
                        <i class="fa-solid fa-angles-right"></i>
                    </button>
                </div>
                <!-- Body -->
                <div class="sider__body">
                    <ul class="sider__body--list">
                        <li>
                            <a class="sider--button {{ Route::currentRouteName() === 'studentAdminIndex' ? 'active' : '' }}"
                                href="{{ route('studentAdminIndex') }}">
                                <i class="fa-solid fa-lg fa-house"></i>
                                <span class="sider__item--title">Asosiy</span>
                            </a>
                        </li>
                        <li>
                            <a class="sider--button {{ request()->routeIs('studentAdminSubjects') ? 'active' : '' }}"
                                href="{{ route('studentAdminSubjects') }}">
                                <i class="fa-solid fa-lg fa-list"></i>
                                <span class="sider__item--title">Fanlar ro'yxati</span>
                            </a>
                        </li>
                        <li>
                            <a class="sider--button {{ request()->routeIs('studentAdminCurrent') ? 'active' : '' }}"
                                href="{{ route('studentAdminCurrent') }}">
                                <i class="fa-solid fa-spinner"></i>
                                <span class="sider__item--title">Joriy nazorat</span>
                            </a>
                        </li>
                        <li>
                            <a class="sider--button {{ request()->routeIs('studentAdminMiddleexam') ? 'active' : '' }}"
                                href="{{ route('studentAdminMiddleexam') }}">
                                <i class="fa-solid fa-lg fa-clipboard-list"></i>
                                <span class="sider__item--title">Oraliq</span>
                            </a>
                        </li>
                        <li>
                            <a class="sider--button {{ request()->routeIs('studentAdminSelfstudy') ? 'active' : '' }}"
                                href="{{ route('studentAdminSelfstudy') }}">
                                <i class="fa-solid fa-file-circle-check"></i>
                                <span class="sider__item--title">Mustaqil talim</span>
                            </a>
                        </li>
                        <li>
                            <a class="sider--button {{ request()->routeIs('studentAdminRetry') ? 'active' : '' }}"
                                href="{{ route('studentAdminRetry') }}">
                                <i class="fa-solid fa-lg fa-clock-rotate-left"></i>
                                <span class="sider__item--title">Qayta o'zlashtirish</span>
                            </a>
                        </li>
                        <li>
                            <a class="sider--button {{ request()->routeIs('studentAdminFinal') ? 'active' : '' }}"
                                href="{{ route('studentAdminFinal') }}">
                                <i class="fa-solid fa-flag-checkered"></i>
                                <span class="sider__item--title">Yakuniya nazorat</span>
                            </a>
                        </li>

                        <li>
                            <a class="sider--button {{ request()->routeIs('studentAdminResult') ? 'active' : '' }}"
                                href="{{ route('studentAdminResult') }}">
                                <i class="fa-solid fa-lg fa-ranking-star"></i>
                                <span class="sider__item--title">Natijalarni ko'rish</span>
                            </a>
                        </li>
                    </ul>

                </div>

                <!-- Footer -->
                <div class="sider__footer">
                    <form id="logout-form" action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button class="btn btn-logout" type="submit">
                            <svg width="32" height="32" viewBox="0 0 32 32" fill="none"
                                xmlns="http://www.w3.org/2000/svg">
                                <path
                                    d="M15.3236 2.66675C18.6337 2.66675 21.3333 5.32008 21.3333 8.58675V14.9734H13.1938C12.6104 14.9734 12.1492 15.4267 12.1492 16.0001C12.1492 16.5601 12.6104 17.0267 13.1938 17.0267H21.3333V23.4001C21.3333 26.6667 18.6337 29.3334 15.2965 29.3334H8.68988C5.36624 29.3334 2.66663 26.6801 2.66663 23.4134V8.60008C2.66663 5.32008 5.3798 2.66675 8.70345 2.66675H15.3236ZM24.7202 11.4003C25.1202 10.987 25.7736 10.987 26.1736 11.387L30.0669 15.267C30.2669 15.467 30.3736 15.7203 30.3736 16.0003C30.3736 16.267 30.2669 16.5337 30.0669 16.7203L26.1736 20.6003C25.9736 20.8003 25.7069 20.907 25.4536 20.907C25.1869 20.907 24.9202 20.8003 24.7202 20.6003C24.3202 20.2003 24.3202 19.547 24.7202 19.147L26.8536 17.027H21.3336V14.9737H26.8536L24.7202 12.8537C24.3202 12.4537 24.3202 11.8003 24.7202 11.4003Z"
                                    fill="#FF4842" />
                            </svg>
                            <span class="sider__item--title">&nbsp; Chiqish</span>
                        </button>
                    </form>
                </div>
            </div>

            <!-- Main -->
            <main>

                @yield('content')


            </main>

            <!-- Right sider -->
            <livewire:right-sidebar />

            <!-- Mobile bottom bar -->
            <div class="mobile__bottom--bar mobileShow">
                <div>
                    <ul class="mobile__bottom--list">
                        <li class="{{ request()->routeIs('studentAdminIndex') ? 'active' : '' }}">
                            <a class="mobile__bottom--list__link" href="{{ route('studentAdminIndex') }}">
                                <i class="fa fa-home bar__icon"></i>
                                <span class="bar__label">Asosiy</span>
                            </a>
                        </li>
                        <li class="{{ request()->routeIs('studentAdminCurrent') ? 'active' : '' }}">
                            <a class="mobile__bottom--list__link {{ request()->routeIs('studentAdminCurrent') ? 'active' : '' }}"
                            href="{{ route('studentAdminCurrent') }}" >
                                <i class="fa-solid fa-sort-down bar__icon"></i>
                                <span class="bar__label">Joriy</span>
                            </a>
                        </li>
                        <li class="{{ request()->routeIs('studentAdminMiddleexam') ? 'active' : '' }}">
                            <a class="mobile__bottom--list__link" href="{{ route('studentAdminMiddleexam') }}">
                                <i class="fa-solid fa-lg fa-clipboard-list bar__icon {{ request()->routeIs('studentAdminMiddleexam') ? 'active' : '' }}"></i>
                                <span class="bar__label">Oraliq</span>
                            </a>
                        </li>
                        <li class="{{ request()->routeIs('studentAdminSelfstudy') ? 'active' : '' }}">
                            <a class="mobile__bottom--list__link {{ request()->routeIs('studentAdminSelfstudy') ? 'active' : '' }}" href="{{ route('studentAdminSelfstudy') }}">
                                <i class="fa-solid fa-layer-group bar__icon"></i>
                                <span class="bar__label">Mustaqil</span>
                            </a>
                        </li>
                        <li class="{{ request()->routeIs('studentAdminRetry') ? 'active' : '' }}">
                            <a class="mobile__bottom--list__link {{ request()->routeIs('studentAdminRetry') ? 'active' : '' }}" href="{{ route('studentAdminRetry') }}">
                                <i class="fa-solid fa-rotate-right bar__icon"></i>
                                <span class="bar__label">O'zlashtirish</span>
                            </a>
                        </li>
                        <li class="{{ request()->routeIs('studentAdminFinal') ? 'active' : '' }}">
                            <a class="mobile__bottom--list__link {{ request()->routeIs('studentAdminFinal') ? 'active' : '' }}" href="{{ route('studentAdminFinal') }}">
                                <i class="fa-solid fa-flag-checkered bar__icon"></i>
                                <span class="bar__label">Yakuniy</span>
                            </a>
                        </li>

                    </ul>
                </div>
            </div>
        @endauth
    @endif
    <script src="https://code.jquery.com/jquery-3.7.0.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="{{ asset('assets/js/splide/splide.min.js') }}"></script>
    <script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.7/js/dataTables.bootstrap5.min.js"></script>
    <script src="{{ asset('assets/js/app.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"
        integrity="sha512-AA1Bzp5Q0K1KanKKmvN/4d3IRKVlv9PYgwFPvm32nPO6QS8yH1HO7LbgB1pgiOxPtfeg5zEn2ba64MUcqJx6CA=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    @include('sweetalert::alert')
    <script>
        new Splide("#subjectSlider", {
            pagination: false,
            arrows: false,
            gap: "3rem",
            autoWidth: true,
        }).mount();

        new Splide("#headerSlider", {
            pagination: true,
            arrows: false,
        }).mount();

        // new DataTable('#example');

        $('.select2').select2();

        $('#example').DataTable({
            responsive: true

        });
    </script>

    @livewireScripts
</body>

</html>
