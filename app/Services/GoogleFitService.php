<?php

namespace App\Services;

use Cache;
use Exception;
use Google_Client;
use Carbon\Carbon;
use RuntimeException;
use Google_Service_Fitness;
use App\Events\FitDataFetched;
use Google_Service_Fitness_Session;

class GoogleFitService
{
    public static function getGoogleClient()
    {
        $client = new Google_Client();
        $client->setApplicationName('Dashboard');
        $client->setAuthConfig(__DIR__ . '/../../google_auth_config.json');
        $client->addScope([
            Google_Service_Fitness::FITNESS_ACTIVITY_READ,
            Google_Service_Fitness::FITNESS_LOCATION_READ,
        ]);

        $client->setAccessType('offline');
        $client->setIncludeGrantedScopes(true);
        $client->setRedirectUri('https://dashboard.majava.org/google_auth/callback');

        return $client;
    }

    private static function getStepCount(Google_Service_Fitness $service)
    {
        $request = new \Google_Service_Fitness_AggregateRequest;
        $request->setAggregateBy([new \Google_Service_Fitness_AggregateBy([
            'dataTypeName' => 'com.google.step_count.delta',
            'dataSourceId' => 'derived:com.google.step_count.delta:com.google.android.gms:estimated_steps',
        ])]);

        $request->setBucketByTime(new \Google_Service_Fitness_BucketByTime([
            'durationMillis' => 86400000
        ]));

        $request->setStartTimeMillis(today()->timestamp * 1000);
        $request->setEndTimeMillis(today()->addDay()->timestamp * 1000);

        $response = $service->users_dataset->aggregate('me', $request);
        return $response->getBucket()[0]->getDataset()[0]->getPoint()[0]->getValue()[0]->getIntVal();
    }

    private static function getSleepAmount(Google_Service_Fitness $service)
    {
        $response = $service->users_sessions->listUsersSessions('me');

        return collect($response->getSession())->filter(function (Google_Service_Fitness_Session $session) {
                return $session->getActivityType() === 72;
            })->filter(function (Google_Service_Fitness_Session $session) {
                $endTime = $session->getEndTimeMillis() / 1000;
                return Carbon::parse((int) $endTime)->isToday();
            })->map(function (Google_Service_Fitness_Session $session) {
                return ($session->getEndTimeMillis() - $session->getStartTimeMillis()) / 1000;
            })->first() ?? 0;
    }


    /**
     * @return array
     */
    public static function fetch()
    {
        try {
            $client = new Google_Client;
            $client->setAccessToken(Cache::get('google_credentials')['access_token']);
            $service = new Google_Service_Fitness($client);

            // get sleep
            $steps = self::getStepCount($service);
            $sleep = self::getSleepAmount($service);

            $fitData = [
                'steps' => $steps,
                'sleep' => $sleep,
            ];

            Cache::put('fit_data', $fitData, now()->addHours(12));
            event(new FitDataFetched($steps, $sleep));

            return $fitData;
        } catch (Exception $e) {
            throw new RuntimeException($e);
        }
    }

    public static function getOrFetch()
    {
        return Cache::get('fit_data', function () {
            return self::fetch();
        });
    }
}
