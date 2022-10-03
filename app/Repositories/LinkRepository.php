<?php

namespace App\Repositories;

use App\Models\Link;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class LinkRepository
{

    /**
     * @param array $data
     * @return Link
     */
    public function store(array $data): Link
    {
        $data = $this->buildData($data);

        $link = Link::create($data);

        return $link;
    }

    /**
     * Build a key for use to short link
     *
     * @param array $data
     * @return array
     */
    private function buildData(array $data): array
    {
        $data['key'] = Str::random(8);

        $data['user_id'] = Auth::user()->id;

        return $data;
    }
}
