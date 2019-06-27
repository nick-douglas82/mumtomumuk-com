<?php

namespace App\MultiTenancy;

use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Request;

trait MultiTenancy
{
    public function __construct()
    {
        // dd(Request::segment(1));
        DB::purge('mysql');
        Config::set('database.connections.mysql.database', str_replace('-', '_', Request::segment(1)));
    }
}
