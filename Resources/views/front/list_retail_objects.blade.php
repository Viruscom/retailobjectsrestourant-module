@php use Modules\RetailObjectsRestourant\Services\WorkLoadService; @endphp
<div class="contact-boxes">
    <div class="shell">
        <div class="boxes-wrapper">
            @foreach($retailObjects as $retailObject)
                @php
                    $retailObject = $retailObject->translate($languageSlug);
                @endphp
                <div class="box hover-images" data-aos="fade-up">
                    <h3>{{ $retailObject->title }}</h3>

                    <a class="box-link box-link-green" href="tel:{!! $retailObject->phone !!}">
                        <img src="{{ asset('front/assets/icons/phone.svg') }}" alt="">

                        <img src="{{ asset('front/assets/icons/phone-dark.svg') }}" alt="">

                        {!! $retailObject->phone !!}
                    </a>

                    <a class="box-link box-link-orange" href="mailto:{!! $retailObject->email !!}">
                        <img src="{{ asset('front/assets/icons/mail.svg') }}" alt="">

                        <img src="{{ asset('front/assets/icons/mail-dark.svg') }}" alt="">

                        {!! $retailObject->email !!}
                    </a>

                    <a class="box-link box-link-red" href="">
                        <img src="{{ asset('front/assets/icons/pin-red.svg') }}" alt="">

                        <img src="{{ asset('front/assets/icons/pin-red.svg') }}" alt="">

                        {{ $retailObject->address }}
                    </a>

                    @if(WorkLoadService::isRestaurantOpen($retailObject->parent))
                        <p class="label-info label-info-open">В момента е отворено!</p>
                    @else
                        <p class="label-info label-info-closed">В момента е затворено!</p>
                    @endif

                    <a href="{{ $retailObject->url }}" class="btn btn-black">{{ __('front.see_more') }}</a>
                </div>
            @endforeach
        </div>
    </div>
</div>
