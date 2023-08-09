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
                var polygons = [];

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

                    // Load polygons from server
                    $.ajax({
                        url: '{{route('admin.retail-objects-restaurants.delivery-zone.get', ['id' => $retailObject->id])}}',
                        type: 'GET',
                        success: function (data) {
                            // Create a polygon for each set of coordinates
                            data.polygons.forEach(function (polygonCoordinates) {
                                var polygon = new google.maps.Polygon({
                                    paths: polygonCoordinates,
                                    strokeColor: '#ff0000',
                                    strokeOpacity: 0.8,
                                    strokeWeight: 2,
                                    fillColor: '#ff0000',
                                    fillOpacity: 0.35
                                });
                                polygon.setMap(map);
                            });
                        },
                        error: function (error) {
                            console.error(error);
                        }
                    });

                    google.maps.event.addListener(drawingManager, 'polygoncomplete', function (polygon) {
                        var polygonData = polygon.getPath().getArray();
                        polygons.push(polygonData);
                        savePolygonData(polygons);
                    });
                }

                function savePolygonData(polygons) {
                    $.ajax({
                        url: '{{route('admin.retail-objects-restaurants.delivery-zone.update', ['id' => $retailObject->id])}}',
                        type: 'POST',
                        data: JSON.stringify({polygons: polygons}),
                        contentType: 'application/json',
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        success: function (data) {
                            alert('Полигоните бяха записани');
                        },
                        error: function (error) {
                            console.error(error);
                        }
                    });
                }

            </script>
            <script src="https://maps.googleapis.com/maps/api/js?key={{ $GOOGLE_MAPS_API_KEY }}&libraries=drawing,places,geometry&callback=initMap" async defer></script>
        </div>
    </div>
@endsection
