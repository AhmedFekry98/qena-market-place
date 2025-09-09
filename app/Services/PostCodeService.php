<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Exception;

class PostCodeService
{

    public $baseUrl;
    public function __construct()
    {
        $this->baseUrl = env('BASE_URL_POSTCODE');
    }

    public function sendRequest(
        string $method,
        string $endpoint,
        array $data = [],
        array $headers = []
    ) {
        try {
            $url = $this->baseUrl . $endpoint;

            $defaultHeaders = [
                "Accept" => "application/json",
            ];
            // Debug: Log the configuration values

            $headers = array_merge($defaultHeaders, $headers);

            $response = Http::withHeaders($headers)
                ->{$method}($url, $data);
            return $response->json();
        } catch (Exception $e) {
            return ['error' => $e->getMessage()];
        }
    }
}
