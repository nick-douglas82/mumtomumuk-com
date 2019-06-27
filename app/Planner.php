<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Request;


class Planner extends Model
{
    public function week($date)
    {
        $requestedWeek = Carbon::createFromFormat('Y-m-d', $date);

        for ($i = 0; $i < 7; $i++) {
            $week[] = [
                'day'  => Carbon::createFromFormat('Y-m-d', $date)->startOfWeek()->addDays($i)->format('D'),
                'date' => Carbon::createFromFormat('Y-m-d', $date)->startOfWeek()->addDays($i)->format('d')
            ];
        }

        return $week;
    }

    public function getStartDate($date)
    {
        if ( is_null($date) ) {
            return Carbon::now()->startOfWeek()->format('Y-m-d');
        }

        return Carbon::createFromFormat('Y-m-d', $date)->startOfWeek()->format('Y-m-d');
    }

    public function previousWeekUrl($date)
    {
        return url(Request::segment(1) . '/planner/' . Carbon::createFromFormat('Y-m-d', $date)->subWeeks(1)->startOfWeek()->format('Y-m-d'));
    }

    public function nextWeekUrl($date)
    {
        return url(Request::segment(1) . '/planner/' . Carbon::createFromFormat('Y-m-d', $date)->addWeeks(1)->startOfWeek()->format('Y-m-d'));
    }

    public function formatDate($date)
    {
        return Carbon::createFromFormat('Y-m-d', $date)->format('j M Y');
    }

    /**
     * Serve the dates.
     *
     * @var array
     */
    protected $dates = ['created_at', 'updated_at', 'event_start', 'event_end'];
}
