<div class="col-lg-6 col-md-6 mb-4">
    <a
        href="{{ route('StudentExams',['type_id' => $m->examtypes_id,'id' => $m->id])}}"
        class="link-underline link-underline-opacity-0"
    >
        <div class="main__card">
            <div class="card__header">
                <h3 class="card__header--title">{{$m->subject->subject_name}}</h3>
                <h3 class="card__header--title"></h3>
            </div>
            <div class="card__body">
                <div>
                    <p class="card__body--caption"><i class="fa fa-clock"></i> {{$m->start}}</p>
                </div>

                <h5 class="card__body--deadline">{{ $startTime }}</h5>
            </div>
            <div class="card__bg">
                <svg
                    width="106"
                    height="119"
                    viewBox="0 0 106 119"
                    fill="none"
                    xmlns="http://www.w3.org/2000/svg"
                >
                    <circle
                        cx="26.5"
                        cy="39.5"
                        r="68.2181"
                        transform="rotate(46.4144 26.5 39.5)"
                        stroke="url(#paint0_linear_123_10)"
                        stroke-width="21"
                    />
                    <defs>
                        <linearGradient
                            id="paint0_linear_123_10"
                            x1="90.1955"
                            y1="111.608"
                            x2="64.9577"
                            y2="-54.2406"
                            gradientUnits="userSpaceOnUse"
                        >
                            <stop stop-color="#F3F3F3" />
                            <stop offset="1" stop-color="#F1F8FF" />
                        </linearGradient>
                    </defs>
                </svg>
            </div>
        </div>
    </a>
</div>

