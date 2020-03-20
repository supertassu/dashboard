<?php

namespace App\Services;

use App\Events\ScheduleFetched;
use Cache;
use Carbon\Carbon;
use ICal\ICal;

class ScheduleService
{
    /**
     * @return array
     */
    public static function fetch()
    {
        try {
            $ical = new ICal(env('SCHEDULE_ICAL'), [
                'defaultTimeZone' => 'Europe/Helsinki',
            ]);

            $events = $ical->eventsFromRange(now()->format('Y-m-d'), now()->addDays(2)->format('Y-m-d'));
            $schedule = [];

            foreach ($events as $event) {
                $dateKey = (new Carbon($event->dtstart))->format('Y-m-d');
                if (!isset($schedule[$dateKey])) {
                    $schedule[$dateKey] = [];
                }

                $teachers = collect(explode('/', explode("\n", $event->description)[1]))
                    ->map(function ($name) {
                        return substr($name, 4);
                    })
                    ->join(', ');

                $defaultTz = now()->getOffset();

                $startDate = Carbon::make($event->dtstart)->setTimezone($event->dtstart_array['0']['TZID']);
                $offset = $defaultTz - $startDate->getOffset();
                $startDate = $startDate->addSeconds($offset);

                $endDate = Carbon::make($event->dtend)->setTimezone($event->dtend_array['0']['TZID']);
                $endDate = $endDate->addSeconds($offset);

                $schedule[$dateKey][] = [
                    'title' => explode(' ', $event->summary)[0],
                    'teacher' => $teachers,
                    'location' => explode(' ', $event->location)[0],
                    'starts_at' => $startDate->toIso8601String(),
                    'ends_at' => $endDate->toIso8601String(),
                ];
            }

            // dd($schedule);

            Cache::put('schedule', $schedule, now()->addHours(12));
            event(new ScheduleFetched($schedule));

            return $schedule;
        } catch (\Exception $e) {
            throw new \RuntimeException($e);
        }
    }

    public static function getOrFetch()
    {
        return Cache::get('schedule', function () {
            return self::fetch();
        });
    }
}
