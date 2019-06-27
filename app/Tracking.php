<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tracking extends Model
{
    use LocationTrait;

    protected $connection = 'mysql';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id', 'client_ip', 'type', 'from_page', 'gathered_data'
    ];
}
