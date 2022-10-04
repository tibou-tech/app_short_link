<?php

namespace App\Actions;

use App\Models\Link;
use App\Services\GeolocationGetCountryByApiService;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class AccessLinkLogAction
{
    public function __construct(
        private GeolocationGetCountryByApiService $getCountryByIpService
    )
    {
    }

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
            'Pays' => $this->getCountryByIpService->handle('166.171.248.255'), // Ip for test (You must past in param request()->ip())
            'User Agent' => request()->userAgent()
        ]);
    }
}
