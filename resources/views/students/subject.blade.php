
@extends('layouts.student-app')

@section('content')
    <section>
        <h3 class="section__title">Biriktirilgan Fanlar Ro'yhat </h3>

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
    </section>
@endsection
