@extends('layouts.student-app')

@section('content')

    <section class="main__header p-4">
        <div class="d-flex align-items-center gap-2" style="width: 70%">
            <a
                href="/"
                style="display: block"
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
                    src="{{ asset('assets/images/profile-image.jpg') }}"
                    alt="Profile"
                />
                Toshmat
            </button>
            <ul class="dropdown-menu">
                <li><a class="dropdown-item" href="#">Profile</a></li>
            </ul>
        </div>
    </section>
    <!-- Main -->
    <section>
        <h3 class="text-center text-muted m-2">Qoldirirlgan darslar</h3>
        <div class="card p-1">
            <table id="example" class="table table-striped" style="width:100%">
                <thead>

                <tr>
                    <th>Fan</th>
                    <th>Qoldirilgan dars mavzusi</th>
                    <th>Dasr turi</th>
                    <th>Vaqti</th>
                </tr>
                </thead>
                <tbody>
                @foreach($absents as $a)

                <tr>
                    <td>
                        @foreach($subjects as $s)
                                {{$s->subject_name}}
                        @endforeach
                    </td>
                    <td>
                        @foreach($topics as $t)
                            {{$t->topic_name}}
                            @endforeach
                    </td>
                    <td>
                        @foreach($lessons as $l)
                            {{$l->name}}
                        @endforeach
                    </td>
                    <td>
                        @if($a->created_at)
                            {{ $a->created_at}}
                        @else
                            mavjud emas
                        @endif

                    </td>
                </tr>
                @endforeach
                </tbody>
                <tfoot>

                </tfoot>
            </table>
        </div>
    </section>
    <section>
        <h3 class="text-center text-muted">Qayta topshirish testlari</h3>
    </section>

    <section class="row m-0">
        @foreach($retries as $r)
            <livewire:retrisexams :r="$r"/>
        @endforeach
    </section>
@endsection
