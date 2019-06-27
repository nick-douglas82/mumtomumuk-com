<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Favourite extends Model
{
    use RecordsActivity;

    protected $connection = 'milton_keynes';

    /**
     * Don't auto-apply mass assignment protection.
     *
     * @var array
     */
     protected $guarded = [];

    /**
     * Fetch the model that was favourited.
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphTo
     */
    public function subject()
    {
        return $this->morphTo();
    }
}
