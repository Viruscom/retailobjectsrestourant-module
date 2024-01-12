@extends('layouts.admin.app')
@section('styles')
    <link href="{{ asset('admin/assets/css/select2.min.css') }}" rel="stylesheet"/>
@endsection

@section('scripts')
    <script src="{{ asset('admin/assets/js/select2.min.js') }}"></script>
    <script src="{{ asset('admin/plugins/ckeditor/ckeditor.js') }}"></script>
    <script>
        $(".select2").select2({language: "bg"});
        $('.select2').css('min-width', '100%');
    </script>
@endsection
@section('content')
    @include('retailobjectsrestourant::admin.product_additives.breadcrumbs')
    @include('admin.notify')

    <form class="my-form" action="{{ route('admin.product.additives.store') }}" method="POST" data-form-type="store" enctype="multipart/form-data">
        <div class="col-xs-12 p-0">
            <input type="hidden" name="_token" value="{{ csrf_token() }}">

            @include('admin.partials.on_create.form_actions_top')
        </div>
        <div class="row">
            <div class="col-sm-12 col-xs-12">
                <ul class="nav nav-tabs">
                    @foreach($languages as $language)
                        <li @if($language->code === config('default.app.language.code')) class="active" @endif><a data-toggle="tab" href="#{{$language->code}}">{{$language->code}} <span class="err-span-{{$language->code}} hidden text-purple"><i class="fas fa-exclamation"></i></span></a></li>
                    @endforeach
                </ul>
                <div class="tab-content">
                    @foreach($languages as $language)
                        @php
                            $langTitle = 'title_'.$language->code
                        @endphp
                        <div id="{{$language->code}}" class="tab-pane fade in @if($language->code === config('default.app.language.code')) active @endif">
                            <div class="form-group @if($errors->has($langTitle)) has-error @endif">
                                <label class="control-label p-b-10">{{ __('retailobjectsrestourant::admin.product_additives.title') }} (<span class="text-uppercase">{{$language->code}}</span>):</label>
                                <input class="form-control" type="text" name="{{$langTitle}}" value="{{ old($langTitle) }}">
                                @if($errors->has($langTitle))
                                    <span class="help-block">{{ trans($errors->first($langTitle)) }}</span>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>
                <div class="form form-horizontal">
                    <div class="form-body">
                        <hr>
                        <div class="col-md-6">
                            @include('admin.partials.on_create.form_fields.input_text', ['fieldName' => 'price', 'label' => trans('retailobjectsrestourant::admin.product_additives.price'), 'required' => true])
                        </div>
                        <div class="col-md-6">
                            @if(array_key_exists('YanakSoftApi', $activeModules))
                                @include('yanaksoftapi::admin.partials.on_create_select', ['fieldName' => 'stk_idnumb', 'label' => trans('shop::admin.yanak_soft_api.choose_product'), 'models' => $yanakProducts, 'required' => true, 'labelClass' => 'select-label-fix', 'class' => 'select-fix', 'withPleaseSelect' => true])
                            @endif
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            @include('admin.partials.on_create.form_actions_bottom')
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
@endsection
