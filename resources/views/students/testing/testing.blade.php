<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>Oraliq test - My System</title>
    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"/>
    <meta name="description" content="Biznesingizni My System bilan avtomatlashtiring!"/>
    <!-- Icon -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css"/>
    <link rel="stylesheet" href="{{ asset('assets/css/main.css') }}"/>
    <link rel="stylesheet" href="{{ asset('assets/css/splide/splide.min.css') }}"/>
    <link rel="stylesheet" href="{{ asset('assets/css/splide/themes/splide-default.min.css') }}"/>
    <link rel="stylesheet" href="{{ asset('assets/css/exam.css') }}"/>

    <style>
        #question__list {
            overflow: scroll;
            scrollbar-color: black orange;
            scrollbar-width: thin;
            padding: 10px;
        }
    </style>
</head>

<body>
<div class="examp__process--content">
    <!-- Examp ID -->
    <noscript id="examUrl"
              data-check-url='{{ route('examsSelfSolution', ['type_id' => $data->examtypes_id, 'id' => $data->id]) }}'></noscript>
    <!--/ Examp ID -->

<!-- Header -->
    <header class="exam--header">
        <div class="d-flex gap-3">
            <a href="{{ route('studentAdminIndex') }}" class="btn btn-primary exam--header__btn p-0 m-0">
                <i class="fa fa-home"></i>
            </a>
            <h3 class="exam--header__title">
                Test- <span >{{ $data->subject->subject_name ?? "Fan o'chirib yuborilgan" }}</span>

            </h3>
            <h3 class="exam--header__title">
                <span>---</span>
                    <span id="timer">
                            @if($data->examtypes_id == 1)
                                    {{ $data->duration($data->id) }}
                             @elseif($data->examtypes_id == 2)
                                    {{ $data->duration($data->id) }}
                             @elseif($data->examtypes_id == 3)
                                     {{ $data->duration($data->id) }}
                             @elseif ($data->examtypes_id == 4)
                                     {{ $data->duration($data->id) }}
                             @elseif ($data->examtypes_id == 5)
                                     {{ $data->duration($data->id) }}
                             @endif


                    </span>
            </h3>
        </div>
        <button class="btn btn-primary exam--header__btn examp--test__btn" id="examTestMenuBtn">
            <i class="fa fa-bars"></i>
        </button>
    </header>

    <!-- Main -->
    <div class="main__exam" id="questionContent">
        <!-- Pagination -->
        <nav aria-label="Examp pagination" class="d-flex justify-content-center">
            <ul class="pagination main__pagination w-auto">
                <!-- Prev -->
                <li class="page-item disabled" id="questionPaginPrev">
                    <a class="page-link" href="#" tabindex="-1">
                        <i class="fa fa-angle-left"></i>
                    </a>
                </li>
                <!--/ Prev -->

                <!-- Label -->
                <li class="page-item disabled">
                    <a class="page-link main__pagination--counter" href="#">
                        <span id="questionPrevLabel"></span>

                        <span id="questionCurrentLabel" class="counter__active"></span>

                        <span id="questionNextLabel"></span>
                    </a>
                </li>
                <!--/ Label -->

                <!-- Next -->
                <li class="page-item" id="questionPaginNext">
                    <a class="page-link" href="#">
                        <i class="fa fa-angle-right"></i>
                    </a>
                </li>
                <!--/ Next -->
            </ul>
        </nav>

        <!-- Question card -->
        <div class="card question--card" id="questionCard"></div>
        <!-- / Question card -->

        <!-- Variants -->
        <form class="varinat--wrapper" id="variantListForm"></form>
    </div>
</div>
<!-- Exam right sider -->
<div class="exam__right--sider" id="examTestMenu">
    <div class="d-flex gap-3 mb-3 justify-content-between">
        <h3 class="section__title">Testlar ro'yxati</h3>
        <button class="btn btn-text">
            <i class="fa fa-close"></i>
        </button>
    </div>

    <!-- Question list -->
    <div class="question__list" id="question__list"></div>
    <!-- / Question list -->

    <div class="sider__bottom">
        <button class="btn btn-danger shadow w-100" data-bs-toggle="tooltip" data-bs-html="true"
                title="Test savollarini tugatish" id="questionSubmitBtn">
            Tugatish
        </button>
    </div>
</div>
</body>
<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="{{ asset('assets/js/app.js') }}"></script>
<script src="{{ asset('assets/js/question.js') }}"></script>

{{--<script type="text/javascript">--}}

{{--	 window.onbeforeunload = function (e) {--}}
{{--	  // This function triggers before the window closes--}}
{{--	  e = e || window.event; // Support IE--}}

{{--	  // Chrome and other modern browsers might not always confirm!--}}
{{--	  if (e) {--}}
{{--	    e.returnValue = confirm("Are you sure you want to close?");--}}
{{--	  }--}}
{{--	};--}}
{{--</script>--}}

</html>
