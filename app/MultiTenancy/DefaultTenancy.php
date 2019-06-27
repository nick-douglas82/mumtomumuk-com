<?php

namespace App\MultiTenancy;

use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Request;

trait DefaultTenancy
{
    public function __construct()
    {
        DB::purge('mysql');
        Config::set('database.connections.mysql.database', 'mums');
    }
}
