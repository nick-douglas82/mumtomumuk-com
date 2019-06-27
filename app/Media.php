<?php

namespace App;
use Illuminate\Support\Facades\Session;
use Spatie\MediaLibrary\Media as BaseMedia;

class Media extends BaseMedia
{
    protected $connection = '';

    public function __construct()
    {
        $this->connection = Session::get('connection');
    }
}
