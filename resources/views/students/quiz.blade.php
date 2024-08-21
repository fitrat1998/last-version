
@extends('layouts.student-app')

@section('content')

    <div class="examp__process--content">
        <!-- Header -->
        @if($subject)

{{--            @foreach($questions as $question)--}}
{{--                <p>Savol: {{ $question->question }}</p>--}}

{{--                @foreach($question->options as $option)--}}
{{--                    <p>Variant: {{ $option->option }} qiyinchiligi: {{ $option->difficulty }}</p>--}}
{{--                @endforeach--}}

{{--                <br>--}}
{{--            @endforeach--}}
        <header class="exam--header">
            <a href="#" class="btn btn-primary exam--header__btn onPrevAction">
                <i class="fa fa-angle-left"></i>
            </a>
            <h3 class="exam--header__title">
                Mustaqil ta'lim & Test- <span>{{ $subject->subject_name }}</span>

            </h3>
        </header>

        <!-- Main -->
        <div class="main__exam">
            <!-- Pagination -->
            @foreach($tests as $test)
{{--                <h2>Test {{ $loop->index + 1 }}</h2>--}}
            <nav
                aria-label="Examp pagination"
                class="d-flex justify-content-center"
            >
                <ul class="pagination main__pagination w-auto">
                    <li class="page-item disabled">
                        <a class="page-link" href="#" tabindex="-1" aria-disabled="true">
                            <i class="fa fa-angle-left"></i>
                        </a>
                    </li>
                    <li class="page-item disabled">
                        <a class="page-link main__pagination--counter" href="#">
                            <span>{{ $loop->index + 1 }}</span><->{{ $quiz->number }}
                        </a>
                    </li>
                    <li class="page-item">
                        <a class="page-link" href="#">
                            <i class="fa fa-angle-right"></i>
                        </a>
                    </li>
                </ul>
            </nav>

            <!-- Inner -->

            @foreach($test as $question)
            <div class="card question--card">
                <img
                    src="../../../../public/student/assets/images/questions/image-one.jpg"
                    class="card-img-top"
                    alt="Qestion"
                />
                <div class="card-body">
                    Two thin circular discs of mass m and 4m, having radii of a and 2a,
                    respectively, are rigidly fixed by a massless, rigid rod of length =
                    √24a through their centres. This assembly is laid on a firm and flat
                    surface, and set rolling without slipping on the surface so that the
                    angular speed about the axis of the rod is o. The angular momentum
                    of the entire assembly about the point 'O' is L (see the figure).
                    Which of the following statement(s) is (are) true?
                </div>
            </div>

            <!-- Variants -->
            <form class="varinat--wrapper">
                <label for="one" class="variant--card">
                    <input type="radio" id="one" name="variant" />
                    <div class="varinat--card__inner">
                        <h1 class="varinat__title">a)</h1>
                        <p>
                            The magnitude of angular momentum of the assembly about its
                            centre of mass is 17 ma² o/2
                        </p>
                    </div>
                </label>
                <label for="two" class="variant--card">
                    <input type="radio" id="two" name="variant" />
                    <div class="varinat--card__inner">
                        <h1 class="varinat__title">b)</h1>
                        <p>
                            The magnitude of angular momentum of the assembly about its
                            centre of mass is 17 ma² o/2
                        </p>
                    </div>
                </label>
                <label for="three" class="variant--card">
                    <input type="radio" id="three" name="variant" />
                    <div class="varinat--card__inner">
                        <h1 class="varinat__title">c)</h1>
                        <p>
                            The magnitude of angular momentum of the assembly about its
                            centre of mass is 17 ma² o/2
                        </p>
                    </div>
                </label>
                <label for="four" class="variant--card">
                    <input type="radio" id="four" name="variant" />
                    <div class="varinat--card__inner">
                        <h1 class="varinat__title">d)</h1>
                        <p>
                            The magnitude of angular momentum of the assembly about its
                            centre of mass is 17 ma² o/2
                        </p>
                    </div>
                </label>
                <button type="submit" class="btn btn-primary justify-content-right">Jo'natish</button>
            </form>
        </div>

        @endforeach
    </div>
    @endforeach
    @else
        <p>Fan topilmadi</p>
    @endif
@endsection
