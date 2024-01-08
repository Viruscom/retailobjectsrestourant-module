@php use Carbon\Carbon;use Modules\RetailObjectsRestourant\Models\RetailObjectsRestaurantWorkload; @endphp@extends('layouts.admin.app')

@section('content')
    <!-- Стилове за pickadate.js -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/pickadate.js/3.6.4/themes/default.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/pickadate.js/3.6.4/themes/default.time.css">

    <!-- pickadate.js скрипт -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pickadate.js/3.6.4/picker.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pickadate.js/3.6.4/picker.time.js"></script>
    <style>
        .picker__list {
            max-height: 400px;
            overflow-y: scroll;
        }

        .time-picker {
            max-width: 60px;
        }
    </style>

    @include('retailobjectsrestourant::admin.restaurants.breadcrumbs')
    @include('admin.notify')
    <form class="my-form" action="{{ route('admin.retail-objects-restaurants.workload.exceptions.update', ['id' => $retailObject->id]) }}" method="POST" data-form-type="store" enctype="multipart/form-data" autocomplete="off">
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
            @php
                $weekDays = [];
                $startOfWeek = Carbon::now()->startOfWeek();
                for ($i = 0; $i < 7; $i++) {
                    $weekDays[] = $startOfWeek->copy()->addDays($i)->locale(config('default.app.language.code'));
                }
            @endphp
            @foreach($weekDays as $day)
                @php
                    $dayOfWeek = $day->dayOfWeek
                @endphp
                <div class="col-xs-12 col-md-6 m-b-40">
                    <div><h3>Натовареност за <b><i>{{ $day->dayName }}</i></b></h3></div>
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
                                                <input type="text" class="form-control time-picker" name="workload[{{$workloadStatus}}][{{$dayOfWeek}}][form_time]" value="{{ old('workload.' . $workloadStatus . '.' . $dayOfWeek . '.form_time', $workloadData[$workloadStatus][$dayOfWeek]['from_hour'] ?? '') }}" required>

                                            </div>
                                            <div class="form-group m-b-0">
                                                <input type="text" class="form-control time-picker" name="workload[{{$workloadStatus}}][{{$dayOfWeek}}][to_time]" value="{{ old('workload.' . $workloadStatus . '.' . $dayOfWeek . '.to_time', $workloadData[$workloadStatus][$dayOfWeek]['to_hour'] ?? '') }}" required>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="form-group m-b-0">
                                            <select name="workload[{{$workloadStatus}}][{{$dayOfWeek}}][extraordinary_status]">
                                                <option value="{{ RetailObjectsRestaurantWorkload::WORKLOAD_STATUS_WEAK }}" {{ $workloadData[$workloadStatus][$dayOfWeek]['extraordinary_status'] == RetailObjectsRestaurantWorkload::WORKLOAD_STATUS_WEAK ? 'selected':'' }}>Слабо</option>
                                                <option value="{{ RetailObjectsRestaurantWorkload::WORKLOAD_STATUS_MODERATELY }}" {{ $workloadData[$workloadStatus][$dayOfWeek]['extraordinary_status'] == RetailObjectsRestaurantWorkload::WORKLOAD_STATUS_MODERATELY ? 'selected':'' }}>Умерено</option>
                                                <option value="{{ RetailObjectsRestaurantWorkload::WORKLOAD_STATUS_STRONG }}" {{ $workloadData[$workloadStatus][$dayOfWeek]['extraordinary_status'] == RetailObjectsRestaurantWorkload::WORKLOAD_STATUS_STRONG ? 'selected':'' }}>Силно</option>
                                                <option value="{{ RetailObjectsRestaurantWorkload::WORKLOAD_STATUS_VERY_STRONG }}" {{ $workloadData[$workloadStatus][$dayOfWeek]['extraordinary_status'] == RetailObjectsRestaurantWorkload::WORKLOAD_STATUS_VERY_STRONG ? 'selected':'' }}>Много силно</option>
                                                <option value="{{ RetailObjectsRestaurantWorkload::WORKLOAD_STATUS_CLOSED }}" {{ $workloadData[$workloadStatus][$dayOfWeek]['extraordinary_status'] == RetailObjectsRestaurantWorkload::WORKLOAD_STATUS_CLOSED ? 'selected':'' }}>Затворено</option>
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
    <script>
        $(document).ready(function () {
            $('.time-picker').pickatime({
                format: 'HH:i',
                interval: 10,
                editable: false
            });
        });
    </script>
@endsection
