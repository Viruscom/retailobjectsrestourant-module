@extends('layouts.admin.app')

@section('content')
    @include('retailobjectsrestourant::admin.settings.breadcrumbs')
    @include('admin.notify')

    <form action="{{ route('admin.retail-objects-restaurants.settings.update') }}" method="POST">
        <div class="col-xs-12 p-0">
            @csrf
            <div class="bg-grey top-search-bar">
                <div class="action-mass-buttons pull-right">
                    <button type="submit" name="submit" value="submit" class="btn btn-lg save-btn margin-bottom-10"><i class="fas fa-save"></i></button>
                    <a href="{{ route('admin.retail-objects-restaurants.index') }}" role="button" class="btn btn-lg back-btn margin-bottom-10"><i class="fa fa-reply"></i></a>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-sm-12">
                <div class="form form-horizontal">
                    <div class="form-body">
                        <div class="portlet light bordered">
                            <div class="portlet-title">
                                <div class="caption">
                                    <span>@lang('retailobjectsrestourant::admin.settings.index')</span>
                                </div>
                            </div>
                            <div class="portlet-body">
                                @foreach($settings as $setting)
                                    <div class="form-group">
                                        <label class="control-label col-md-3">{{ __('retailobjectsrestourant::admin.settings.'.$setting->key) }}:</label>
                                        <div class="col-md-6">
                                            <input type="text" name="setting[{{$setting->key}}]" value="{{ old($setting->key) ?: $setting->value }}" class="form-control">
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12">
                        <div class="form-actions">
                            <div class="row">
                                <div class="col-md-offset-3 col-md-9">
                                    <button type="submit" name="submit" value="submit" class="btn save-btn margin-bottom-10"><i class="fas fa-save"></i> запиши</button>
                                    <a href="{{ route('admin.retail-objects-restaurants.index') }}" role="button" class="btn back-btn margin-bottom-10"><i class="fa fa-reply"></i> {{ __('admin.common.back') }}</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
@endsection
