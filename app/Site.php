<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Site extends Model
{
    protected $connection = 'mysql';

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'created_at', 'updated_at'
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'slug', 'img_slug', 'active_at'
    ];

    /**
     * Get the route key name for Laravel.
     *
     * @return string
     */
    public function getRouteKeyName()
    {
        return 'slug';
    }

    /**
     * Send part of the url to check if we are current in a site or another part of the site
     *
     * @return collection
     */
    public static function siteChecker($slug)
    {
        return self::whereSlug($slug)->pluck('active_at')->first();
    }

    /**
     * Return correctly formatted database connection name
     *
     * @return string
     */
    public static function formatConnectionName($slug)
    {
        return str_replace('-', '_', $slug);
    }

    /**
     * Grab the image slug from the database and return the storage path
     *
     * @return string
     */
    public function image()
    {
        return Storage::url($this->img_slug);
    }

    /**
     * A check to see if the site is active or not
     *
     * @return boolean
     */
    public function isActive()
    {
        return ( $this->active_at ) ? true : false;
    }
}
