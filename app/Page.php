<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Request;
use Spatie\MediaLibrary\HasMedia\HasMediaTrait;
use Spatie\MediaLibrary\HasMedia\Interfaces\HasMediaConversions;

class Page extends Model implements HasMediaConversions
{
    use HasMediaTrait, PostImageConversion;

    /**
     * The relations to eager load on every query.
     *
     * @var array
     */
    protected $with = ['adverts', 'media'];

    /**
     * Get the route key name for Laravel.
     *
     * @return string
     */
    public function getRouteKeyName()
    {
        return 'slug';
    }

    public function adverts()
    {
        return $this->morphMany(Advertising::class, 'subject');
    }

    public function seo()
    {
        return $this->morphOne(SEO::class, 'subject');
    }
}
