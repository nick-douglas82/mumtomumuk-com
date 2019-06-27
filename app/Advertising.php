<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Advertising extends Model
{

    /**
     * Fields that can be mass assigned.
     *
     * @var array
     */
    protected $fillable = ['id', 'user_id', 'adsense_id', 'ad_type'];

    /**
     * Advertising morphs to models in _type.
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphTo
     */
    public function advertisingable()
    {
        return $this->morphTo();
    }
}
