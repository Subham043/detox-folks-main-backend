<?php

namespace App\Http\Services;

use Ixudra\Curl\Facades\Curl;

class OlaMapService
{
    private string $PROJECT_ID;
    private string $API_KEY;
    private string $CLIENT_ID;
    private string $CLIENT_SECRET;
    private bool $ENABLED = false;

    public function __construct(){
        $this->PROJECT_ID = config('app.map.project_id');
        $this->API_KEY = config('app.map.api_key');
        $this->CLIENT_ID = config('app.map.client_id');
        $this->CLIENT_SECRET = config('app.map.client_secret');
        $this->ENABLED = config('app.map.enabled');
    }

    public function authenticate():string
    {
        $response = Curl::to('https://account.olamaps.io/realms/olamaps/protocol/openid-connect/token')
                ->withHeader('Content-Type:application/x-www-form-urlencoded')
                ->withHeader('accept:application/json')
                ->withData([
                    'grant_type' => 'client_credentials',
                    'scope' => 'openid',
                    'client_id' => $this->CLIENT_ID,
                    'client_secret' => $this->CLIENT_SECRET,
                ])
                ->post();
        return json_decode($response)->access_token;
    }

    public function get_autocomplete(string $keyword)
    {
        if(!$this->ENABLED) return [];
        $token = $this->authenticate();
        $response = Curl::to('https://api.olamaps.io/places/v1/autocomplete')
                ->withHeader('Content-Type:application/x-www-form-urlencoded')
                ->withHeader('accept:application/json')
                ->withBearer($token)
                ->withData([
                    'input' => $keyword,
                    'api_key' => $this->API_KEY,
                ])
                ->get();
        return json_decode($response)->predictions;
    }

    public function get_reverse_geoconding(float $lat, float $lng)
    {
        if(!$this->ENABLED) return [];
        $token = $this->authenticate();
        $response = Curl::to('https://api.olamaps.io/places/v1/reverse-geocode')
                ->withHeader('Content-Type:application/x-www-form-urlencoded')
                ->withHeader('accept:application/json')
                ->withBearer($token)
                ->withData([
                    'latlng' => $lat.','.$lng,
                    'api_key' => $this->API_KEY,
                ])
                ->get();
        return json_decode($response)->results;
    }

    public function get_geoconding(string $address)
    {
        if(!$this->ENABLED) return [];
        $token = $this->authenticate();
        $response = Curl::to('https://api.olamaps.io/places/v1/geocode')
                ->withHeader('Content-Type:application/x-www-form-urlencoded')
                ->withHeader('accept:application/json')
                ->withBearer($token)
                ->withData([
                    'address' => $address,
                    'api_key' => $this->API_KEY,
                ])
                ->get();
        return json_decode($response)->geocodingResults;
    }

    public function get_place_info_by_id(string $place_id)
    {
        if(!$this->ENABLED) return [];
        $token = $this->authenticate();
        $response = Curl::to('https://api.olamaps.io/places/v1/details')
                ->withHeader('Content-Type:application/x-www-form-urlencoded')
                ->withHeader('accept:application/json')
                ->withBearer($token)
                ->withData([
                    'place_id' => $place_id,
                    'api_key' => $this->API_KEY,
                ])
                ->get();
        return json_decode($response);
    }

    public function get_direction(float $origin_lat, float $origin_lng, float $destination_lat, float $destination_lng)
    {
        if(!$this->ENABLED) return [];
        $token = $this->authenticate();
        $response = Curl::to('https://api.olamaps.io/routing/v1/directions')
                ->withHeader('Content-Type:application/x-www-form-urlencoded')
                ->withHeader('accept:application/json')
                ->withBearer($token)
                ->withData([
                    'origin' => $origin_lat.','.$origin_lng,
                    'destination' => $destination_lat.','.$destination_lng,
                    'api_key' => $this->API_KEY,
                ])
                ->post();
        return json_decode($response);
    }

    public function get_optimized_routes(string $locations)
    {
        if(!$this->ENABLED) return [];
        $token = $this->authenticate();
        $response = Curl::to('https://api.olamaps.io/routing/v1/routeOptimizer')
                ->withHeader('Content-Type:application/x-www-form-urlencoded')
                ->withHeader('accept:application/json')
                ->withBearer($token)
                ->withData([
                    'locations' => $locations,
                    'api_key' => $this->API_KEY,
                ])
                ->post();
        return json_decode($response);
    }

}
