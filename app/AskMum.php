<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Laravel\Scout\Searchable;

class AskMum extends Model
{
    use Searchable; //LocationTrait

    // protected $connection = 'mysql';

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
     * Get the indexable data array for the model.
     *
     * @return array
     */
    public function toSearchableArray()
    {
        return [
            'question' => $this->question,
            'answer' => $this->answer,
            'slug' => $this->slug,
            'type' => 'askmum'
        ];
    }

    /**
     * Askmum morphs to many (many-to-many) .
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphToMany
     */
    public function adverts()
    {
        return $this->morphMany(Advertising::class, 'subject');
    }

    public function seo()
    {
        return $this->morphOne(SEO::class, 'subject');
    }
}
