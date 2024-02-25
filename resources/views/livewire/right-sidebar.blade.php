<div class="right__sider">
    <!-- Head -->
    <div class="right__sider--head">
        <button class="btn btn-text">
            <img width="26" src="{{ asset('assets/images/notif-icon.svg') }}" alt="Notif icon" />
            <span class="main__badge">9</span>
        </button>
        <button type="button" class="btn btn-text dropdown-toggle" data-bs-toggle="dropdown"
                aria-expanded="false">
            <img class="profile__small--image" src="{{ asset('assets/images/profile-image.png') }}" alt="Profile" />
            {{-- {{ auth()->user()->email }} --}}
        </button>
        <ul class="dropdown-menu">
            <li><a class="dropdown-item" href="{{ route('StudentProfile') }}">Profile</a></li>
        </ul>
    </div>

    <div class="right__sider--body">
        <!-- Profile -->
        <div class="right__sider--profile">
            <!-- Head -->
            <div class="right__sider--profile__body">
                <img class="profile__large--image"
                     src="{{ asset('assets/images/profile-image.png') }}"
                     style="background: #fff"
                     alt="Profile photo" />
                <h3 class="profile__title">{{ auth()->user()->name }}</h3>
            </div>
            <div class="profile__footer">
{{--                <p class="profile__footer--text">{{ $group->id }}</p>--}}

                <div class="profile__footer--btn">
                    <svg width="16" height="16" viewBox="0 0 16 16" fill="none"
                         xmlns="http://www.w3.org/2000/svg">
                        <path
                            d="M8.754 4.91283C8.79267 4.9505 8.958 5.09273 9.094 5.22522C9.94933 6.00197 11.3493 8.02827 11.7767 9.08883C11.8453 9.2499 11.9907 9.65711 12 9.87468C12 10.0832 11.952 10.2819 11.8547 10.4715C11.7187 10.7079 11.5047 10.8976 11.252 11.0015C11.0767 11.0684 10.552 11.1723 10.5427 11.1723C9.96867 11.2762 9.036 11.3334 8.00533 11.3334C7.02333 11.3334 6.12867 11.2762 5.546 11.1911C5.53667 11.1814 4.88467 11.0775 4.66133 10.9638C4.25333 10.7553 4 10.3481 4 9.91234V9.87468C4.01 9.59086 4.26333 8.99401 4.27267 8.99401C4.70067 7.9906 6.032 6.01106 6.91667 5.21548C6.91667 5.21548 7.144 4.99142 7.286 4.894C7.49 4.74202 7.74267 4.66669 7.99533 4.66669C8.27733 4.66669 8.54 4.75177 8.754 4.91283Z"
                            fill="white" />
                    </svg>
                    32 (+2%)
                </div>
            </div>
            <!-- Footer -->
        </div>
        <!-- List -->
        <div class="right__sider--list">
            <br><h3 class="section__title">Bugungi testlar</h3>
            <ul class="right__sider--list__inner--list">
{{--                @foreach($selfstudyexams as $s)--}}
{{--                    <li class="list__inner--item">--}}
{{--                        <a class="list__inner--item--btn" href="#">--}}
{{--                            <div class="slider__list--icon">--}}
{{--                                <img src="{{ asset('assets/images/math-icon.svg') }}" alt="Math icon" />--}}
{{--                            </div>--}}
{{--                            <div style="width: calc(100% - 48px)">--}}
{{--                                <div class="d-flex gap-3 justify-content-between">--}}
{{--                                    <h4 class="sider__list--item--title">{{ $s->subject->subject_name ?? "Mavjud emas" }}</h4>--}}
{{--                                    <h4 class="sider__list--item--count">48</h4>--}}
{{--                                </div>--}}
{{--                                <div class="d-flex gap-3 justify-content-between">--}}
{{--                                    <span class="sider__list--item--caption"><i class="fa fa-clock"></i> {{ $s->start }}</span>--}}
{{--                                    <span class="sider__list--item--caption"><i class=""></i></span>--}}
{{--                                </div>--}}
{{--                            </div>--}}
{{--                        </a>--}}
{{--                    </li>--}}
{{--                @endforeach--}}
            </ul>
        </div>
    </div>
</div>
