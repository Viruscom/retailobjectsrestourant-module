<section class="section section-zones">
    <div class="section-aside">
        <h3 class="title" data-aos="fade-up" data-aos-delay="60">{{ __('front.delivery_zones') }}</h3>

        <a href="" class="btn-zones">
            <img src="{{ asset('front/assets/images/zone.jpg') }}" alt="" data-aos="fade-up" data-aos-delay="100">
        </a>
    </div>

    <div class="section-inner">
        <h3 class="title" data-aos="fade-up" data-aos-delay="60">{{ __('front.our_objects') }}</h3>

        <div class="section-inner-content">
            <div class="slider-zones">
                @foreach($viewArray['RetailObjectsRestourant'] as $retailObject)
                    @php
                        $retailObject = $retailObject->translate($languageSlug);
                        if ($loop->first) {
                            $retailObjectUrl = $retailObject->url;
                        }
                    @endphp
                    <div class="zone-el" data-aos="fade-up">
                        <h4>
                            <a href="{{ url($languageSlug.'/'.$retailObjectUrl) }}">{{ $retailObject->title }}</a>
                        </h4>

                        <p>{{ $retailObject->address }}</p>

                        <h5>Работно време: </h5>

                        <p><strong>понеделник-петък</strong> {{ $retailObject->working_time_mon_fri }}</p>
                        <p><strong>събота</strong> {{ $retailObject->working_time_saturday }}</p>
                        <p><strong>неделя</strong> {{ $retailObject->working_time_sunday }}</p>

                        <a href="tel:{!! $retailObject->phone !!}">тел. {!! $retailObject->phone !!}</a>
                    </div>
                @endforeach
            </div>

            <a href="{{ url($languageSlug.'/'.$retailObjectUrl) }}" class="show-more" data-aos="fade-in" data-aos-delay="60">виж всички обекти »</a>
        </div>
    </div>
</section>
