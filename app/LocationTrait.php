<?php
namespace App;

trait LocationTrait {

    protected $connection = 'mysql';

    public function __construct()
    {
        $this->connection = $this->setLocation();
    }

    public function setLocation()
    {
        if (request()->segment(1) == 'api') {
            return 'milton_keynes';
        }

        return str_replace('-', '_', request()->segment(1));
    }
}
