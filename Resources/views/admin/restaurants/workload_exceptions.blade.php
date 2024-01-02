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
                <h3>Приоритетна натоваренст за ресторант: <strong>{{ $retailObject->title }}</strong></h3><br>
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
                                <th>Приоритетна натовареност</th>
                                <th>Активност</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach(RetailObjectsRestaurantWorkload::getWorkloadStatuses() as $workloadStatus)
                                <tr>
                                    <td>{{ RetailObjectsRestaurantWorkload::statusMapping($workloadStatus) }}</td>
                                    <td>
                                        <div style="display: flex;">
                                            <div class="form-group m-r-10 m-b-0">
                                                <input type="time" class="form-control" name="workload[{{$workloadStatus}}][{{$dayOfWeek}}][form_time]" value="{{ old('workload.' . $workloadStatus . '.' . $dayOfWeek . '.form_time', $workloadData[$workloadStatus][$dayOfWeek]['from_hour'] ?? '') }}" required disabled>

                                            </div>
                                            <div class="form-group m-b-0">
                                                <input type="time" class="form-control" name="workload[{{$workloadStatus}}][{{$dayOfWeek}}][to_time]" value="{{ old('workload.' . $workloadStatus . '.' . $dayOfWeek . '.to_time', $workloadData[$workloadStatus][$dayOfWeek]['to_hour'] ?? '') }}" required disabled>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="form-group m-b-0">
                                            <select name="workload[{{RetailObjectsRestaurantWorkload::WORKLOAD_STATUS_WEAK}}][{{$dayOfWeek}}][extraordinary_status]">
                                                <option value="{{ RetailObjectsRestaurantWorkload::WORKLOAD_STATUS_WEAK }}">Слабо</option>
                                                <option value="{{ RetailObjectsRestaurantWorkload::WORKLOAD_STATUS_MODERATELY }}">Умерено</option>
                                                <option value="{{ RetailObjectsRestaurantWorkload::WORKLOAD_STATUS_STRONG }}">Силно</option>
                                                <option value="{{ RetailObjectsRestaurantWorkload::WORKLOAD_STATUS_VERY_STRONG }}">Много силно</option>
                                                <option value="{{ RetailObjectsRestaurantWorkload::WORKLOAD_STATUS_CLOSED }}">Затворено</option>
                                            </select>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="form-group">
                                            <label class="switch pull-left">
                                                <input type="checkbox" name="workload[{{$workloadStatus}}][{{$dayOfWeek}}][has_extraordinary_status]" class="success" data-size="small" @if(old('workload.' . $workloadStatus . '.' . $dayOfWeek . '.has_extraordinary_status', $workloadData[$workloadStatus][$dayOfWeek]['has_extraordinary_status'] ?? '') || $workloadData[$workloadStatus][$dayOfWeek]['has_extraordinary_status'])
                                                    {{ 'checked' }}
                                                    @else
                                                    {{ 'active' }}
                                                    @endif>
                                                <span class="slider"></span>
                                            </label>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            @endforeach
        </div>
        @include('admin.partials.on_edit.form_actions_bottom')
    </form>
@endsection
