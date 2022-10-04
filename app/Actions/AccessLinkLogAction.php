<?php

namespace App\Actions;

use App\Models\Link;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class AccessLinkLogAction
{

    /**
     * Register log infos for user access link in 'accesslog' channel
     *
     * @param Link $link
     * @return void
     */
    public function handle(Link $link)
    {
        Log::channel('accesslog')->info('access', [
            'Le temps d\'accès' => Carbon::now(),
            'Le lien accédé' => $link->origin_link,
            'Utilisateur ID' => Auth::user() ? Auth::user()->id : null,
            'Addresse IP' => request()->ip(),
            'Pays' => $this->getCountryByIp('166.171.248.255'), // Ip for test (You must past in param request()->ip())
            'User Agent' => request()->userAgent()
        ]);
    }

    /**
     * Use ipgeolocation abstractapi for get country from IP address
     *
     * @param string $ip
     * @return string|null
     */
    private function getCountryByIp(string $ip): string|null
    {
        try {
            // Initialize cURL.
            $ch = curl_init();

            $apiKey = config('services.ipgeolocation.key');

            $ipGeolocation = "https://ipgeolocation.abstractapi.com/v1/?api_key={$apiKey}&ip_address={$ip}&fields=country";

            // Set the URL that you want to GET by using the CURLOPT_URL option.
            curl_setopt($ch, CURLOPT_URL, $ipGeolocation);

            // Set CURLOPT_RETURNTRANSFER so that the content is returned as a variable.
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

            // Set CURLOPT_FOLLOWLOCATION to true to follow redirects.
            curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);

            // Execute the request.
            $data = curl_exec($ch);

            // Close the cURL handle.
            curl_close($ch);

            // Print the data out onto the page.
            $data = json_decode($data, true);

            if (!$data) {
                return null;
            }

            return $data['country'];
        } catch (Exception $e) {
            throw $e->getMessage();
        }
    }
}
