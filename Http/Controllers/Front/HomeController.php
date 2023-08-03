<?php

namespace Modules\RetailObjectsRestourant\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Modules\RetailObjectsRestourant\APIS\GoogleGeoCodingApi;

class HomeController extends Controller
{
    public function getAddressCoordinates(Request $request)
    {
        $API = GoogleGeoCodingApi::getInstance();
        $API->getApiKey();

        $client = new Client();

        $address    = $request->input('address');
        $attributes = [
            'headers' => [
                'Content-Type' => 'application/json',
            ],
            'query'   => [
                'address' => $address,
                'key'     => $API->getApiKey(),
            ],
            'verify'  => false,
        ];

        $response = $client->get('https://maps.googleapis.com/maps/api/geocode/json', $attributes);

        $data = $response->getBody()->getContents();
        $data = json_decode($data, true);

        if ($data['status'] === 'OK') {
            $location  = $data['results'][0]['geometry']['location'];
            $latitude  = $location['lat'];
            $longitude = $location['lng'];

            return response()->json([
                                        'latitude'  => $latitude,
                                        'longitude' => $longitude,
                                    ]);
        } else {
            return response()->json([
                                        'error' => 'Неуспешна заявка към API.',
                                    ], 400);
        }
    }
}
