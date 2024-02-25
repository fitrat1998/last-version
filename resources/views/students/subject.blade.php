
@extends('layouts.student-app')

@section('content')
    <section>
        <h3 class="section__title">Biriktirilgan Fanlar Ro'yhat</h3>

        <div class="splide" aria-label="Fanlar ro'yhati">
            <div class="splide__track">
                <ul class="splide__list">
                    @foreach($subjects as $subject)
                        <li class="splide__slide">
                            <div class="slider__list--item">
                                <button type="button" class="slider__list--body" wire:click="openSubject({{ $subject->id }})">
                                    <div class="slider__list--icon">
                                        <img
                                            src="{{asset('assets/images/subject-icon.svg')}}"
                                            alt="Subject icon"
                                        />
                                    </div>
                                    <div>
                                        <h4 class="slider__list--title">{{ $subject->subject_name }}</h4>
                                    </div>
                                </button>
                            </div>
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>
    </section>
@endsection
