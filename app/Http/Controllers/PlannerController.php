<?php

namespace App\Http\Controllers;

use App\Planner;
use App\Site;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class PlannerController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Site $site, $date = null, Planner $planner)
    {
        $weekStartDate = $planner->getStartDate($date);

        $thisweek = $planner->week($weekStartDate);

        if ( is_null($date) ) {
            return Redirect::to($site->slug . '/planner/' . $weekStartDate);
        }
        elseif ( ! is_null($date) && $date != $weekStartDate ) {
            return Redirect::to($site->slug . '/planner/' . $weekStartDate);
        }

        return view('user.planner', compact('thisweek', 'weekStartDate', 'planner'));
    }

    function search(Site $site, $date, Request $request)
    {

        $e = Planner::where('event_start', '>=', Carbon::createFromFormat('Y-m-d', $date)->format('Y-m-d'))
                    ->where('event_start', '<=', Carbon::createFromFormat('Y-m-d', $date)->addDays(7)->format('Y-m-d'))
                    ->whereIn('age', (is_null($request->ages)) ? [] : $request->ages)
                    ->orderBy('event_start', 'asc')
                    ->get();

        $week = [];

        for ($i = 0; $i < 7; $i++) {
            $day         = [];
            $date        = Carbon::createFromFormat('Y-m-d', $date)->startOfWeek()->addDays($i)->format('Y-m-d');
            $day['date'] = $date;

            $todays = $e->filter(function ($value, $key) use ($date) {
                return $value->event_start->format('Y-m-d') == $date;
            });

            if ( !is_null($request->times) && count($request->times) == 1 ) {

                if (in_array('am', $request->times)) {
                    $day['am'] = $todays->filter(function ($value, $key) use ($date) {
                        return $value->event_start->format('a') == 'am';
                    });

                    $day['pm'] = [];
                }

                if (in_array('pm', $request->times)) {
                    $day['am'] = [];

                    $day['pm'] = $todays->filter(function ($value, $key) use ($date) {
                        return $value->event_start->format('a') == 'pm';
                    });
                }
            }
            elseif (empty($request->times)) {
                $day['am'] = [];
                $day['pm'] = [];
            }
            else {
                $day['am'] = $todays->filter(function ($value, $key) use ($date) {
                    return $value->event_start->format('a') == 'am';
                });

                $day['pm'] = $todays->filter(function ($value, $key) use ($date) {
                    return $value->event_start->format('a') == 'pm';
                });
            }

            $week[] = $day;
        }

        return $week;
    }
}
