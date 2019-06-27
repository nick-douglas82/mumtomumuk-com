<?php

namespace App;

use App\Activity;
use Illuminate\Support\Facades\Auth;


trait RecordsActivity
{
    public function recordRelatedActivity($subject, $relation)
    {
        $activity               = new Activity;
        $activity->user_id      = auth()->id();
        $activity->subject_id   = $subject->id;
        $activity->type         = "saved_{$this->getActivityType($relation)}";
        $activity->subject_type = get_class($subject);

        return $activity->save();
    }

    public function recordDirectActivity($subject)
    {
        $activity               = new Activity;
        $activity->user_id      = auth()->id();
        $activity->subject_id   = $subject->id;
        $activity->type         = "saved_{$this->getActivityType($subject)}";
        $activity->subject_type = get_class($subject);

        return $activity->save();
    }

    /**
     * Determine the activity type.
     *
     * @param  string $event
     * @return string
     */
    protected function getActivityType($event)
    {
        return strtolower((new \ReflectionClass($event))->getShortName());
    }

    /**
     * Fetch the activity relationship.
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphMany
     */
    public function activity()
    {
        return $this->morphMany('App\Activity', 'subject');
    }
}
