@extends('layouts.admin.app')
@section('scripts')
    <script src="{{ asset('admin/plugins/ckeditor/ckeditor.js') }}"></script>
    <script>
        var focusedEditor;
        CKEDITOR.timestamp = new Date();
        CKEDITOR.on('instanceReady', function (evt) {
            var editor = evt.editor;
            editor.on('focus', function (e) {
                focusedEditor = e.editor.name;
            });
        });
    </script>
@endsection

@section('content')
    @include('retailobjectsrestourant::admin.breadcrumbs')
    @include('admin.notify')
    <form class="my-form" action="{{ route('admin.retail-objects-restaurants.update', ['id' => $retailObject->id]) }}" method="POST" data-form-type="store" enctype="multipart/form-data" autocomplete="off">
        <span class="hidden curr-editor"></span>
        <div class="col-xs-12 p-0">
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
            <input type="hidden" name="position" value="{{old('position')}}">
            @include('admin.partials.on_edit.form_actions_top')
        </div>
        <div class="row">
            <div class="col-sm-12 col-xs-12">
                <ul class="nav nav-tabs nav-tabs-first">
                    @foreach($languages as $language)
                        <li @if($language->code === config('default.app.language.code')) class="active" @endif>
                            <a data-toggle="tab" href="#{{$language->code}}">
                                {{$language->code}} <span class="err-span-{{$language->code}} hidden text-purple"><i class="fas fa-exclamation"></i></span>
                            </a>
                        </li>
                    @endforeach
                </ul>
                <div class="tab-content m-b-0">
                    @foreach($languages as $language)
                        @php
                            $retailObjectTranslate = is_null($retailObject->translate($language->code)) ? $retailObject : $retailObject->translate($language->code);
                        @endphp
                        <div id="{{$language->code}}" class="tab-pane fade in @if($language->code === config('default.app.language.code')) active @endif">
                            <div class="row">
                                <div class="col-md-6 col-xs-12">
                                    @include('admin.partials.on_edit.form_fields.input_text', ['fieldName' => 'title_' . $language->code, 'label' => trans('retailobjectsrestourant::admin.title'), 'required' => true, 'model' => $retailObjectTranslate])
                                    @include('admin.partials.on_edit.form_fields.input_text', ['fieldName' => 'phone_' . $language->code, 'label' => trans('retailobjectsrestourant::admin.phone'), 'required' => true, 'model' => $retailObjectTranslate])
                                </div>
                                <div class="col-md-6 col-xs-12">
                                    @include('admin.partials.on_edit.form_fields.input_text', ['fieldName' => 'address_' . $language->code, 'label' => trans('retailobjectsrestourant::admin.address'), 'required' => true, 'model' => $retailObjectTranslate])
                                    @include('admin.partials.on_edit.form_fields.input_text', ['fieldName' => 'email_' . $language->code, 'label' => trans('retailobjectsrestourant::admin.email'), 'required' => true, 'model' => $retailObjectTranslate])
                                </div>
                                <div class="col-md-12 col-xs-12">
                                    <div class="form-group @if($errors->has('map_iframe_' . $language->code)) has-error @endif">
                                        <label class="control-label p-b-10">
                                            <span class="text-purple">* </span>
                                            {{trans('retailobjectsrestourant::admin.map_iframe')}} (<span class="text-uppercase">{{$language->code}}</span>):
                                        </label>
                                        <input class="form-control" type="text" name="{{'map_iframe_' . $language->code}}" value="{{ old('map_iframe_' . $language->code) ?: $retailObjectTranslate->map_iframe }}">
                                        @if($errors->has('map_iframe_' . $language->code))
                                            <span class="help-block">{{ trans($errors->first('map_iframe_' . $language->code)) }}</span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            @include('admin.partials.on_edit.form_fields.textarea_without_ckeditor', ['fieldName' => 'announce_' . $language->code, 'rows' => 4, 'label' => trans('admin.announce'), 'required' => false, 'model' => $retailObjectTranslate])
                            @include('admin.partials.on_edit.form_fields.textarea', ['fieldName' => 'description_' . $language->code, 'rows' => 9, 'label' => trans('admin.description'), 'required' => false, 'model' => $retailObjectTranslate])
                            @include('admin.partials.on_edit.show_in_language_visibility_checkbox', ['fieldName' => 'visible_' . $language->code, 'model' => $retailObject])
                        </div>
                    @endforeach
                </div>
                <ul class="nav nav-tabs-second">
                    @foreach($languages as $language)
                        <li @if($language->code === config('default.app.language.code')) class="active" @endif><a langcode="{{$language->code}}">{{$language->code}}</a></li>
                    @endforeach
                </ul>
                <hr>
                @include('admin.partials.on_edit.seo', ['model' => $retailObject->seoFields])
                <div class="form form-horizontal">
                    <div class="form-body">
                        <div class="row">
                            <div class="col-md-12">
                                <h3>{{ __('retailobjectsrestourant::admin.restaurants_working_time.index') }}</h3>
                            </div>
                        </div>
                        <div class="row p-0 m-0">
                            <div class="col-xs-12 col-md-6 p-r-30">
                                @include('admin.partials.on_edit.form_fields.input_text_without_lang', ['fieldName' => 'working_time_mon_fri', 'label' => trans('retailobjectsrestourant::admin.restaurants.working_time_mon_fri'), 'required' => true, 'model' => $retailObject])
                            </div>
                            <div class="col-xs-12 col-md-6">
                                @include('admin.partials.on_edit.form_fields.input_text_without_lang', ['fieldName' => 'working_time_saturday', 'label' => trans('retailobjectsrestourant::admin.restaurants.working_time_saturday'), 'required' => true, 'model' => $retailObject])
                                @include('admin.partials.on_edit.form_fields.input_text_without_lang', ['fieldName' => 'working_time_sunday', 'label' => trans('retailobjectsrestourant::admin.restaurants.working_time_sunday'), 'required' => true, 'model' => $retailObject])
                            </div>
                        </div>
                        <div class="row">
                            <hr>
                        </div>
                        @include('admin.partials.on_edit.form_fields.upload_file', ['model' => $retailObject, 'deleteRoute' => route('admin.retail-objects-restaurants.delete-image', ['id'=>$retailObject->id])])
                        @include('admin.partials.on_edit.active_checkbox', ['model' => $retailObject])
                    </div>
                    @include('admin.partials.on_edit.form_actions_bottom')
                </div>
            </div>
        </div>
    </form>
@endsection
