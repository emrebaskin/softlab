<?php


namespace App\Foursquare;

use Guzzle\Http\Exception\BadResponseException;
use Guzzle\Http\Exception\ClientErrorResponseException;
use Guzzle\Http\Exception\ServerErrorResponseException;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use Ixudra\Curl\Facades\Curl;

/**
 * Class Foursquare
 * @package App\Foursquare
 */
class Foursquare
{

    private $clientId;
    private $clientSecret;
    private $apiUrl;

    /**
     * Foursquare constructor.
     */
    public function __construct()
    {

        $this->apiUrl       = "https://api.foursquare.com/v2/venues/";
        $this->clientId     = env('FOURSQUARE_API_CLIENT_ID', '');
        $this->clientSecret = env('FOURSQUARE_API_CLIENT_SECRET', '');

    }

    public function explore(array $params = [])
    {

        $params = $this->addCredentials($params);

        $result = $this->get($this->apiUrl.'explore', $params);

        return response()->json($result->response, $result->statusCode);

    }

    private function addCredentials(array $queryParams = [])
    {

        $credentials = [
            'client_id'     => $this->clientId,
            'client_secret' => $this->clientSecret,
            'v'             => date('Ymd'),
        ];

        return array_merge($queryParams, $credentials);
    }

    private function get($endpoint, $params)
    {

        $response = Curl::to($endpoint)
            ->withData($params)
            ->asJsonResponse()
            ->returnResponseObject()
            ->get();

        return (object) [
            'statusCode' => $response->status,
            'response'   => $response->content,
        ];

    }

    public function categories()
    {

        $params = $this->addCredentials();

        $result = $this->get($this->apiUrl.'categories', $params);

        return response()->json($result->response, $result->statusCode);

    }

}
