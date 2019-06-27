<?php

namespace App\Importer;

use Carbon\Carbon;
use App\Planner;

class PlannerEvent
{
    protected $data;

    protected $frequency;

    public function __construct($data)
    {
        $this->data      = $data;
        $this->frequency = $data->acf->frequency;
    }

    public function create()
    {
        ($this->frequency === '1off') ? $this->oneOff() : null;
        ($this->frequency === 'weekly') ? $this->weekly() : null;
        ($this->frequency === 'monthly') ? $this->monthly() : null;
        ($this->frequency === '2weeks') ? $this->everyTwoWeeks() : null;
        ($this->frequency === '4weeks') ? $this->everyFourWeeks() : null;
    }

    public function update()
    {
        $this->destroy();
        $this->create();
    }

    public function destroy()
    {
        Planner::where('wp_id', $this->data->id)->delete();
    }

    public function oneOff()
    {
        $post              = new Planner;

        $post->wp_id       = $this->data->id;
        $post->user_id     = $this->data->author;
        $post->name        = $this->data->title->rendered;
        $post->address     = $this->data->acf->address->address;
        $post->age         = $this->age();
        $post->event_url   = ( isset($this->data->acf->event_link) ) ? $this->data->acf->event_link : '';
        $post->frequency   = $this->data->acf->frequency;
        $post->event_start = Carbon::parse($this->data->acf->start_date_and_time);
        $post->event_end   = Carbon::parse($this->data->acf->end_date_and_time);
        $post->created_at  = Carbon::parse($this->data->date);
        $post->updated_at  = Carbon::parse($this->data->modified);
        $post->save();
    }

    public function weekly()
    {
        $startDate = Carbon::parse($this->data->acf->first_event_date);
        $endDate   = Carbon::parse($this->data->acf->until);

        for ($date = $startDate; $date->lte($endDate); $date->addWeek()) {
            $post              = new Planner;

            $post->wp_id       = $this->data->id;
            $post->user_id     = $this->data->author;
            $post->name        = $this->data->title->rendered;
            $post->address     = $this->data->acf->address->address;
            $post->age         = $this->age();
            $post->event_url   = ( isset($this->data->acf->event_link) ) ? $this->data->acf->event_link : '';
            $post->frequency   = $this->data->acf->frequency;
            $post->event_start = $date->format('Y-m-d ' . $this->data->acf->start_time_of_event);
            $post->event_end   = $date->format('Y-m-d ' . $this->data->acf->end_time_of_event);
            $post->created_at  = Carbon::parse($this->data->date);
            $post->updated_at  = Carbon::parse($this->data->modified);
            $post->save();
        }
    }

    public function monthly()
    {
        $startDate = Carbon::parse($this->data->acf->first_event_date);
        $endDate   = Carbon::parse($this->data->acf->until);

        for ($date = $startDate; $date->lte($endDate); $date->addMonth()) {
            $post              = new Planner;

            $post->wp_id       = $this->data->id;
            $post->user_id     = $this->data->author;
            $post->name        = $this->data->title->rendered;
            $post->address     = $this->data->acf->address->address;
            $post->age         = $this->age();
            $post->event_url   = ( isset($this->data->acf->event_link) ) ? $this->data->acf->event_link : '';
            $post->frequency   = $this->data->acf->frequency;
            $post->event_start = $date->format('Y-m-d ' . $this->data->acf->start_time_of_event);
            $post->event_end   = $date->format('Y-m-d ' . $this->data->acf->end_time_of_event);
            $post->created_at  = Carbon::parse($this->data->date);
            $post->updated_at  = Carbon::parse($this->data->modified);
            $post->save();
        }
    }

    public function everyTwoWeeks()
    {
        $startDate = Carbon::parse($this->data->acf->first_event_date);
        $endDate   = Carbon::parse($this->data->acf->until);

        for ($date = $startDate; $date->lte($endDate); $date->addWeeks(2)) {
            $post              = new Planner;

            $post->wp_id       = $this->data->id;
            $post->user_id     = $this->data->author;
            $post->name        = $this->data->title->rendered;
            $post->address     = $this->data->acf->address->address;
            $post->age         = $this->age();
            $post->event_url   = ( isset($this->data->acf->event_link) ) ? $this->data->acf->event_link : '';
            $post->frequency   = $this->data->acf->frequency;
            $post->event_start = $date->format('Y-m-d ' . $this->data->acf->start_time_of_event);
            $post->event_end   = $date->format('Y-m-d ' . $this->data->acf->end_time_of_event);
            $post->created_at  = Carbon::parse($this->data->date);
            $post->updated_at  = Carbon::parse($this->data->modified);
            $post->save();
        }
    }

    public function everyFourWeeks()
    {
        $startDate = Carbon::parse($this->data->acf->first_event_date);
        $endDate   = Carbon::parse($this->data->acf->until);

        for ($date = $startDate; $date->lte($endDate); $date->addWeeks(4)) {
            $post              = new Planner;

            $post->wp_id       = $this->data->id;
            $post->user_id     = $this->data->author;
            $post->name        = $this->data->title->rendered;
            $post->address     = $this->data->acf->address->address;
            $post->age         = $this->age();
            $post->event_url   = ( isset($this->data->acf->event_link) ) ? $this->data->acf->event_link : '';
            $post->frequency   = $this->data->acf->frequency;
            $post->event_start = $date->format('Y-m-d ' . $this->data->acf->start_time_of_event);
            $post->event_end   = $date->format('Y-m-d ' . $this->data->acf->end_time_of_event);
            $post->created_at  = Carbon::parse($this->data->date);
            $post->updated_at  = Carbon::parse($this->data->modified);
            $post->save();
        }
    }

    public function age()
    {
        return (isset($this->data->_embedded->{"wp:term"})) ? collect($this->data->_embedded->{"wp:term"})->collapse()->first()->slug : '';
    }
}
