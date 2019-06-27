<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Activity extends Model
{
    protected $connection = 'milton_keynes';

    /**
      * Fields that can be mass assigned.
      *
      * @var array
      */
     protected $fillable = ['type', 'user_id', 'subject_id', 'subject_type'];

    /**
     * Fetch the associated subject for the activity.
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphTo
     */
    public function subject()
    {
        return $this->morphTo();
    }
}
