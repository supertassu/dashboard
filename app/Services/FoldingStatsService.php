<?php

namespace App\Services;

use Carbon\Carbon;
use App\Events\FoldingStatsFetched;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;

class FoldingStatsService
{
    /**
     * @return array
     */
    public static function fetch()
    {
        try {
            $folding = Http::get('https://stats.foldingathome.org/api/team/' . env('FOLDING_TEAM'))
                ->json();

            if (!is_array($folding)) {
                throw new \Exception('Could not fetch folding stats');
            }

            Cache::put('folding', $folding, now()->addHours(3));
            Cache::put('folding-at', now(), now()->addHours(3));
            event(new FoldingStatsFetched($folding));

            return $folding;
        } catch (\Exception $e) {
            throw new \RuntimeException($e);
        }
    }

    public static function getOrFetch()
    {
        if (Cache::has('folding-at') && Carbon::make(Cache::get('folding-at'))->diffInRealMinutes(now()) > 30) {
            try {
                self::fetch();
            }
            catch (\Exception $ignored) {}
        }

        $folding = Cache::get('folding', function () {
            return self::fetch();
        });

        $at = Cache::get('folding-at');

        return compact('folding', 'at');
    }

}
