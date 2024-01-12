<?php

    namespace Modules\RetailObjectsRestourant\Http\Controllers\Front;

    use App\Http\Controllers\Controller;
    use GuzzleHttp\Client;
    use Illuminate\Http\Request;
    use Illuminate\Support\Facades\Auth;
    use Modules\RetailObjectsRestourant\APIS\GoogleGeoCodingApi;
    use Modules\RetailObjectsRestourant\Models\RetailObjectsRestourant;

    class HomeController extends Controller
    {
        public function getAddressCoordinates(Request $request)
        {
            $API = GoogleGeoCodingApi::getInstance();
            $API->getApiKey();

            $client = new Client();

            $address    = $request->city . ',' . $request->address . ' ' . $request->street_number;
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
                $location          = $data['results'][0]['geometry']['location'];
                $isDeliveryAddress = $this->checkAddress($location, true);

                if ($isDeliveryAddress) {
                    if (Auth::guard('shop')->guest()) {
                        session()->put('validated_delivery_address', $request->address);
                        session()->put('validated_zip_code', $request->zip_code);
                        session()->put('validated_street_number', $request->street_number);
                    } else {
                        $registeredUser = Auth::guard('shop')->user();
                        if ($request->has('shipment_address_id')) {
                            $hasAddedAddress = $registeredUser->shipmentAddresses()->where('id', $request->shipment_address_id)->first();
                        } else {
                            $hasAddedAddress = $registeredUser->shipmentAddresses()->where('street', $request->address)->first();
                        }

                        if (!is_null($hasAddedAddress)) {
                            session()->put('validated_shipment_address_object', $hasAddedAddress);
                            session()->put('validated_shipment_address_id', $hasAddedAddress->id);
                            session()->put('validated_delivery_address', $hasAddedAddress->street);
                            session()->put('validated_zip_code', $hasAddedAddress->zip_code);
                            session()->put('validated_street_number', $hasAddedAddress->street_number);
                        }

                        session()->put('validated_delivery_address', $request->address);
                        session()->put('validated_zip_code', $request->zip_code);
                        session()->put('validated_street_number', $request->street_number);
                    }

                    return response()->json(['success' => 'Чудесно! Вашият адрес е в зоната на доставка']);
                } else {
                    if (session()->has('validated_delivery_address')) {
                        session()->forget('validated_delivery_address');
                    }

                    if (session()->has('validated_zip_code')) {
                        session()->forget('validated_zip_code');
                    }

                    if (session()->has('validated_street_number')) {
                        session()->forget('validated_street_number');
                    }

                    return response()->json(['error' => 'За съжаление, Вашият адрес не е в зоната на доставка']);
                }
            } else {
                if (session()->has('validated_delivery_address')) {
                    session()->forget('validated_delivery_address');
                }

                if (session()->has('validated_zip_code')) {
                    session()->forget('validated_zip_code');
                }

                if (session()->has('validated_street_number')) {
                    session()->forget('validated_street_number');
                }

                return response()->json(['error' => 'За съжаление, Вашият адрес не е в зоната на доставка']);
            }
        }

        public function getAddressCoordinatesRegUser(Request $request)
        {
            $API = GoogleGeoCodingApi::getInstance();
            $API->getApiKey();

            $client     = new Client();
            $address    = $request->city . ',' . $request->address . ' ' . $request->street_number;
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
            $response   = $client->get('https://maps.googleapis.com/maps/api/geocode/json', $attributes);

            $data = $response->getBody()->getContents();
            $data = json_decode($data, true);

            if ($data['status'] === 'OK') {
                $location          = $data['results'][0]['geometry']['location'];
                $isDeliveryAddress = $this->checkAddress($location, false);

                if ($isDeliveryAddress) {
                    return response()->json(['success' => 'Чудесно! Вашият адрес е в зоната на доставка', 'data' => ['address_street' => $request->address, 'zip_code' => $request->zip_code, 'street_number' => $request->street_number, 'entrance' => $request->entrance, 'floor' => $request->floor, 'apartment' => $request->apartment, 'bell_name' => $request->bell_name]]);
                } else {
                    return response()->json(['error' => 'За съжаление, Вашият адрес не е в зоната на доставка']);
                }
            } else {
                return response()->json(['error' => 'За съжаление, Вашият адрес не е в зоната на доставка']);
            }
        }

        private function checkAddress($location, $withSession)
        {
            $restaurants = RetailObjectsRestourant::where('active', true)->with('deliveryZone')->get();
            foreach ($restaurants as $restaurant) {
                if ($restaurant->isPointInPolygon($location, $restaurant->deliveryZone[0]->polygon)) {
                    if ($withSession) {
                        session()->put('delivery_restaurant', $restaurant);
                    }

                    return true;
                }
            }

            return false;
        }
    }
