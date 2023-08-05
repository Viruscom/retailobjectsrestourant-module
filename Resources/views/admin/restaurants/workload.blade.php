@php use Carbon\Carbon;use Modules\RetailObjectsRestourant\Models\RetailObjectsRestaurantWorkload; @endphp@extends('layouts.admin.app')

@section('content')
    @include('retailobjectsrestourant::admin.restaurants.breadcrumbs')
    @include('admin.notify')
    <form class="my-form" action="{{ route('admin.retail-objects-restaurants.workload.update', ['id' => $retailObject->id]) }}" method="POST" data-form-type="store" enctype="multipart/form-data" autocomplete="off">
        <span class="hidden curr-editor"></span>
        <div class="col-xs-12 p-0">
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
            <input type="hidden" name="position" value="{{old('position')}}">
            @include('admin.partials.on_edit.form_actions_top')
        </div>

        <div class="row">
            <div class="col-md-12">
                <h3>Натоваренст за ресторант: <strong>{{ $retailObject->title }}</strong></h3><br>
            </div>
        </div>
        <div class="row">
            @foreach([0,1,2,3,4,5,6] as $dayOfWeek)
                <div class="col-xs-12 col-md-6 m-b-40">
                    <div><h3>Натовареност за <b><i>{{ Carbon::now()->startOfWeek()->addDays($dayOfWeek)->locale(config('default.app.language.code'))->dayName }}</i></b></h3></div>
                    <div>
                        <table style="width: 100%;">
                            <thead style="line-height: 40px;">
                            <tr>
                                <th>Натовареност</th>
                                <th>От час / До час</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr>
                                <td>Слабо</td>
                                <td>
                                    <div style="display: flex;">
                                        <div class="form-group m-r-10 m-b-0">
                                            <input type="time" class="form-control" name="workload[{{RetailObjectsRestaurantWorkload::WORKLOAD_STATUS_WEAK}}][{{$dayOfWeek}}][form_time]" value="{{ old('workload.' . RetailObjectsRestaurantWorkload::WORKLOAD_STATUS_WEAK . '.' . $dayOfWeek . '.form_time', $workloadData[RetailObjectsRestaurantWorkload::WORKLOAD_STATUS_WEAK][$dayOfWeek]['from_hour'] ?? '') }}" required="">

                                        </div>
                                        <div class="form-group m-b-0">
                                            <input type="time" class="form-control" name="workload[{{RetailObjectsRestaurantWorkload::WORKLOAD_STATUS_WEAK}}][{{$dayOfWeek}}][to_time]" value="{{ old('workload.' . RetailObjectsRestaurantWorkload::WORKLOAD_STATUS_WEAK . '.' . $dayOfWeek . '.to_time', $workloadData[RetailObjectsRestaurantWorkload::WORKLOAD_STATUS_WEAK][$dayOfWeek]['to_hour'] ?? '') }}" required>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>Умерено</td>
                                <td>
                                    <div style="display: flex;">
                                        <div class="form-group m-r-10 m-b-0">
                                            <input type="time" class="form-control" name="workload[{{RetailObjectsRestaurantWorkload::WORKLOAD_STATUS_MODERATELY}}][{{$dayOfWeek}}][form_time]" value="{{ old('workload.' . RetailObjectsRestaurantWorkload::WORKLOAD_STATUS_MODERATELY . '.' . $dayOfWeek . '.form_time', $workloadData[RetailObjectsRestaurantWorkload::WORKLOAD_STATUS_MODERATELY][$dayOfWeek]['from_hour'] ?? '') }}" required>
                                        </div>
                                        <div class="form-group m-b-0">
                                            <input type="time" class="form-control" name="workload[{{RetailObjectsRestaurantWorkload::WORKLOAD_STATUS_MODERATELY}}][{{$dayOfWeek}}][to_time]" value="{{ old('workload.' . RetailObjectsRestaurantWorkload::WORKLOAD_STATUS_MODERATELY . '.' . $dayOfWeek . '.to_time', $workloadData[RetailObjectsRestaurantWorkload::WORKLOAD_STATUS_MODERATELY][$dayOfWeek]['to_hour'] ?? '') }}" required>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>Силно</td>
                                <td>
                                    <div style="display: flex;">
                                        <div class="form-group m-r-10 m-b-0">
                                            <input type="time" class="form-control @error('workload.' . RetailObjectsRestaurantWorkload::WORKLOAD_STATUS_STRONG . '.' . $dayOfWeek . '.form_time') is-invalid @enderror" name="workload[{{RetailObjectsRestaurantWorkload::WORKLOAD_STATUS_STRONG}}][{{$dayOfWeek}}][form_time]" value="{{ old('workload.' . RetailObjectsRestaurantWorkload::WORKLOAD_STATUS_STRONG . '.' . $dayOfWeek . '.form_time', $workloadData[RetailObjectsRestaurantWorkload::WORKLOAD_STATUS_STRONG][$dayOfWeek]['from_hour'] ?? '') }}" required>
                                            @error('workload.' . RetailObjectsRestaurantWorkload::WORKLOAD_STATUS_STRONG . '.' . $dayOfWeek . '.form_time')
                                            <span class="invalid-feedback" role="alert">
            <strong>{{ $message }}</strong>
        </span>
                                            @enderror
                                        </div>
                                        <div class="form-group m-b-0">
                                            <input type="time" class="form-control @error('workload.' . RetailObjectsRestaurantWorkload::WORKLOAD_STATUS_STRONG . '.' . $dayOfWeek . '.to_time') is-invalid @enderror" name="workload[{{RetailObjectsRestaurantWorkload::WORKLOAD_STATUS_STRONG}}][{{$dayOfWeek}}][to_time]" value="{{ old('workload.' . RetailObjectsRestaurantWorkload::WORKLOAD_STATUS_STRONG . '.' . $dayOfWeek . '.to_time', $workloadData[RetailObjectsRestaurantWorkload::WORKLOAD_STATUS_STRONG][$dayOfWeek]['to_hour'] ?? '') }}" required>
                                            @error('workload.' . RetailObjectsRestaurantWorkload::WORKLOAD_STATUS_STRONG . '.' . $dayOfWeek . '.to_time')
                                            <span class="invalid-feedback" role="alert">
            <strong>{{ $message }}</strong>
        </span>
                                            @enderror
                                        </div>

                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>Много силно</td>
                                <td>
                                    <div style="display: flex;">
                                        <div class="form-group m-r-10 m-b-0">
                                            <input type="time" class="form-control" name="workload[{{RetailObjectsRestaurantWorkload::WORKLOAD_STATUS_VERY_STRONG}}][{{$dayOfWeek}}][form_time]" value="{{ $workloadData[RetailObjectsRestaurantWorkload::WORKLOAD_STATUS_VERY_STRONG][$dayOfWeek]['from_hour'] ?? '' }}" required>
                                        </div>
                                        <div class="form-group m-b-0">
                                            <input type="time" class="form-control" name="workload[{{RetailObjectsRestaurantWorkload::WORKLOAD_STATUS_VERY_STRONG}}][{{$dayOfWeek}}][to_time]" value="{{ $workloadData[RetailObjectsRestaurantWorkload::WORKLOAD_STATUS_VERY_STRONG][$dayOfWeek]['to_hour'] ?? '' }}" required>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>Затворено</td>
                                <td>
                                    <div style="display: flex;">
                                        <div class="form-group m-r-10 m-b-0">
                                            <input type="time" class="form-control" name="workload[{{RetailObjectsRestaurantWorkload::WORKLOAD_STATUS_CLOSED}}][{{$dayOfWeek}}][form_time]" value="{{ $workloadData[RetailObjectsRestaurantWorkload::WORKLOAD_STATUS_CLOSED][$dayOfWeek]['from_hour'] ?? '' }}" required>
                                        </div>
                                        <div class="form-group m-b-0">
                                            <input type="time" class="form-control" name="workload[{{RetailObjectsRestaurantWorkload::WORKLOAD_STATUS_CLOSED}}][{{$dayOfWeek}}][to_time]" value="{{ $workloadData[RetailObjectsRestaurantWorkload::WORKLOAD_STATUS_CLOSED][$dayOfWeek]['to_hour'] ?? '' }}" required>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            @endforeach
        </div>
        @include('admin.partials.on_edit.form_actions_bottom')
    </form>
@endsection
