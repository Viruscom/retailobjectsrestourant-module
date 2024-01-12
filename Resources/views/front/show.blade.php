@php use App\Helpers\ModuleHelper;use Modules\RetailObjectsRestourant\Services\WorkLoadService; @endphp@extends('layouts.front.app')

@section('styles')
    <link rel="stylesheet" type="text/css" href="{{ asset('/front/plugins/cubeportfolio/css/cubeportfolio.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('/front/plugins/cubeportfolio/css/remove_padding.css') }}">
@endsection

@section('scripts')
    <script type="text/javascript" src="{{ asset('/front/plugins/cubeportfolio/js/jquery.cubeportfolio.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('/front/plugins/cubeportfolio/js/main.js') }}"></script>
@endsection

@section('content')
    @include('front.partials.inner_header')
    @include('front.partials.breadcrumbs')

    <div class="page-content">
        <div class="shell">
            <div class="place-picker">
                <h3 data-aos="fade-up" data-aos-delay="50">Нашите обекти:</h3>

                <ul>
                    @foreach($viewArray['RetailObjectsRestourant'] as $retailObject)
                        @php
                            $retailObject = $retailObject->translate($languageSlug);
                        @endphp
                        <li data-aos="fade-up" class="{{ url()->current() === url($languageSlug.'/'.$retailObject->url) ? 'active' : '' }}">
                            <a href="{{ $retailObject->url }}">{{ $retailObject->title }}</a>
                        </li>
                    @endforeach
                </ul>
            </div>

            <div class="place-info">
                <div class="box" data-aos="fade-up" data-aos-delay="50">
                    <div class="box-head">
                        <h3>контакти</h3>
                    </div>

                    <div class="box-content hover-images">
                        <a class="box-link box-link-green" href="tel:{{$viewArray['currentModel']->phone}}">
                            <img src="{{ asset('front/assets/icons/phone.svg') }}" alt="">

                            <img src="{{ asset('front/assets/icons/phone-dark.svg') }}" alt="">

                            {{$viewArray['currentModel']->phone}}
                        </a>

                        <a class="box-link box-link-orange" href="mailto:{{$viewArray['currentModel']->email}}">
                            <img src="{{ asset('front/assets/icons/mail.svg') }}" alt="">

                            <img src="{{ asset('front/assets/icons/mail-dark.svg') }}" alt="">

                            {{$viewArray['currentModel']->email}}
                        </a>

                        <a class="box-link box-link-red" href="https://www.google.bg/maps/place/{{$viewArray['currentModel']->address}}" target="_blank">
                            <img src="{{ asset('front/assets/icons/pin-red.svg') }}" alt="">

                            <img src="{{ asset('front/assets/icons/pin-red.svg') }}" alt="">

                            {{$viewArray['currentModel']->address}}
                        </a>
                    </div>
                </div>

                <div class="box" data-aos="fade-up" data-aos-delay="100">
                    <div class="box-head">
                        <h3>Работно време</h3>

                        @if(WorkLoadService::isRestaurantOpen($viewArray['currentModel']->parent))
                            <p class="label-info label-info-open">В момента е отворено!</p>
                        @else
                            <p class="label-info label-info-closed">В момента е затворено!</p>
                        @endif
                    </div>

                    <div class="box-content">
                        <div class="schedule">
                            <p>
                                <span>Понеделник - Петък</span> {{$viewArray['currentModel']->parent->working_time_mon_fri}} </p>
                            <p>
                                <span>Събота</span> {{$viewArray['currentModel']->parent->working_time_saturday}} </p>
                            <p>
                                <span>Неделя</span> {{$viewArray['currentModel']->parent->working_time_sunday}} </p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="article">
                <p data-aos="fade-up" data-aos-delay="100">{!! $viewArray['currentModel']->description !!}</p>
                @include('front.partials.content.after_description_modules', ['model' => $viewArray['currentModel']])
                @include('front.partials.content.additional_titles_and_texts', ['model' => $viewArray['currentModel']])
            </div>
        </div>

        <div class="page-gallery" data-aos="fade-up" data-aos-delay="100">
            @include('front.partials.content.inner_gallery')
        </div>
@endsection
