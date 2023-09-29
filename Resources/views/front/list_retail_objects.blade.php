<div class="section-maps">

    <div class="map-element">
        <div class="map-wrapper" data-aos="fade-up" data-aos-delay="50">
            <iframe class="map" allowfullscreen="" frameborder="0" width="100%" height="550" src="{{ $retailObject->map_iframe }}"></iframe>
        </div>

        <h4></h4>

        <p></p>
        <p>tel. <a href="tel:{!! $retailObject->phone !!}"></a></p>
        <p><a href="mailto:">{!! $retailObject->email !!}</a></p>
    </div>

</div>

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

                    <p class="label-info label-info-open">В момента е отворено!</p>

                    <a href="{{ $retailObject->url }}" class="btn btn-black">{{ __('front.see_more') }}</a>
                </div>
            @endforeach
        </div>
    </div>
</div>
