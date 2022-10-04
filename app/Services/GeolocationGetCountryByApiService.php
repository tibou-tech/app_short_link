<?php

namespace App\Services;

use Exception;

class GeolocationGetCountryByApiService
{

    /**
     * Use ipgeolocation abstractapi for get country from IP address
     *
     * @param string $ip
     * @return string|null
     */
    public function handle(string $ip): string|null
    {
        try {
            $apiKey = config('services.ipgeolocation.key');

            $urlGeolocation = "https://ipgeolocation.abstractapi.com/v1/?api_key={$apiKey}&ip_address={$ip}&fields=country";

            $data = $this->curlProcessData($urlGeolocation);

            // Transform json data to array
            $data = json_decode($data, true);

            if (!$data) {
                return null;
            }

            return $data['country'];
        } catch (Exception $e) {
            throw $e->getMessage();
        }
    }

    /**
     * @param string $url
     * @return string|null
     */
    private function curlProcessData(string $url): string|null
    {
        // Initialize cURL.
        $ch = curl_init();

        // Set the URL that you want to GET by using the CURLOPT_URL option.
        curl_setopt($ch, CURLOPT_URL, $url);

        // Set CURLOPT_RETURNTRANSFER so that the content is returned as a variable.
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        // Set CURLOPT_FOLLOWLOCATION to true to follow redirects.
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);

        // Execute the request.
        $data = curl_exec($ch);

        // Close the cURL handle.
        curl_close($ch);

        return $data;
    }
}
