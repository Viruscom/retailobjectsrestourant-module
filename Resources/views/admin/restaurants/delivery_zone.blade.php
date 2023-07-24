@extends('layouts.admin.app')

@section('content')
    <style>
        #map {
            min-height: 750px;
            width:      100%;
        }
    </style>
    @include('retailobjectsrestourant::admin.restaurants.breadcrumbs')
    @include('admin.notify')
    <div class="col-xs-12 p-0">
        <div class="bg-grey top-search-bar">
            <div class="action-mass-buttons pull-right">
                <a href="{{ route('admin.retail-objects-restaurants.index') }}" role="button" class="btn btn-lg back-btn margin-bottom-10">
                    <i class="fa fa-reply"></i>
                </a>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <h3>Зона на доставка за ресторант: <strong>{{ $retailObject->title }}</strong></h3><br>
        </div>
    </div>
    <div class="row">
        <div class="col-xs-12">
            <div id="map"></div>

            <script>
                // Инициализирайте картата
                function initMap() {
                    var map = new google.maps.Map(document.getElementById('map'), {
                        zoom: 8,
                        center: {lat: 42.7339, lng: 25.4858},
                    });

                    var drawingManager = new google.maps.drawing.DrawingManager({
                        drawingMode: google.maps.drawing.OverlayType.POLYGON,
                        drawingControl: true,
                        drawingControlOptions: {
                            position: google.maps.ControlPosition.TOP_CENTER,
                            drawingModes: ['polygon']
                        }
                    });

                    drawingManager.setMap(map);

                    var polygonCoordinates = {!! $retailObject->deliveryZone->polygon !!};
                    var existingPolygon    = new google.maps.Polygon({
                        paths: polygonCoordinates,
                        strokeColor: '#ff0000',
                        strokeOpacity: 0.8,
                        strokeWeight: 2,
                        fillColor: '#ff0000',
                        fillOpacity: 0.35
                    });
                    existingPolygon.setMap(map);

                    // При промяна на режима на рисуване, изтрийте съществуващия полигон
                    google.maps.event.addListener(drawingManager, 'drawingmode_changed', function () {
                        if (drawingManager.getDrawingMode() === 'polygon') {
                            existingPolygon.setMap(null);
                        }
                    });

                    google.maps.event.addListener(drawingManager, 'polygoncomplete', function (polygon) {
                        // Изпратете полигоналните данни на сървъра
                        var polygonData = polygon.getPath().getArray();
                        savePolygonData(polygonData);

                        // Изключете инструмента за рисуване след като полигонът е завършен
                        drawingManager.setDrawingMode(null);
                    });

                    var address = 'софия, бул. рожен 10';
                    checkAddressInPolygon(address, existingPolygon);
                }

                // Изпратете полигоналните данни на сървъра
                function savePolygonData(polygonData) {
                    $.ajax({
                        url: '{{route('admin.retail-objects-restaurants.delivery-zone.update', ['id' => $retailObject->id])}}',
                        type: 'POST',
                        data: JSON.stringify({polygon: polygonData}),
                        contentType: 'application/json',
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}' // Ако използвате CSRF защита в Laravel
                        },
                        success: function (data) {
                            alert(data);
                        },
                        error: function (error) {
                            console.error(error);
                        }
                    });

                }

                function checkAddressInPolygon(address, polygon) {
                    var geocoder = new google.maps.Geocoder();

                    geocoder.geocode({'address': address}, function (results, status) {
                        if (status === 'OK') {
                            var point    = results[0].geometry.location;
                            var isInside = google.maps.geometry.poly.containsLocation(point, polygon);

                            if (isInside) {
                                console.log(address + ' is inside the polygon.');
                            } else {
                                console.log(address + ' is not inside the polygon.');
                            }
                        } else {
                            console.log('Geocode was not successful for the following reason: ' + status);
                        }
                    });
                }

                $(document).ready(function () {
                });

            </script>
            <script src="https://maps.googleapis.com/maps/api/js?key={{ $GOOGLE_MAPS_API_KEY }}&libraries=drawing,places,geometry&callback=initMap" async defer></script>
        </div>
    </div>
@endsection
