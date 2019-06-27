<?php

namespace App;

use App\Activity;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Spatie\MediaLibrary\HasMedia\HasMediaTrait;
use Spatie\MediaLibrary\HasMedia\Interfaces\HasMediaConversions;
use Laravel\Scout\Searchable;

class Event extends Model implements HasMediaConversions
{
    use Favouritable, HasMediaTrait, FilteredImageEventHomepageConversion, RecordsActivity, Searchable; //LocationTrait

    // protected $connection = 'mysql';

    /**
     * The relations to eager load on every query.
     *
     * @var array
     */
    protected $with = ['media'];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = ['isFavorited'];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
     protected $hidden = [
        'coordinates', 'updated_at'
    ];

    /**
     * Serve the dates.
     *
     * @var array
     */
    protected $dates = ['created_at', 'updated_at', 'event_at', 'event_end'];

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
        // return $this->toArray() + ['type' => 'events'];
        return [
            'title'      => $this->title,
            'slug'       => $this->slug,
            'categories' => $this->extractTags(),
            'type'       => 'events'
        ];
    }

    /**
     * Return an array of tag names to add to indexable data.
     *
     * @return array
     */
    public function extractTags()
    {
        return $this->tags->unique()->map(function ($tag) {
            return $tag->name;
        });
    }

    public function scopeCloseTo(Builder $query, $latitude, $longitude, $distance)
    {
        return $query->whereRaw(
            "ST_Distance_Sphere(coordinates, POINT(?, ?)) * .000621371192 < ?",
            [$latitude, $longitude, $distance]
        );
    }

    public function eventDate($start, $end)
    {
        return $start->format('D, j M Y, H:i') . '-' . $end->format('H:i');
    }

    public function url($site)
    {
        return url($site . '/events/' . $this->slug);
    }

    function scopeFeatured($query, $number)
    {
        return $query->where('featured', 1)->limit($number)->get();
    }

    /**
     * Event belongs to Tags.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function tags()
    {
        return $this->belongsToMany(Tag::class, 'taggables', 'taggables_id');
    }

    /**
     * Event morphs to many (many-to-many) .
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphToMany
     */
    public function adverts()
    {
        return $this->morphMany(Advertising::class, 'subject');
    }

    /**
     * Get all of the Event's suggestions.
     */
    public function suggestions()
    {
        return $this->morphMany(Suggestion::class, 'suggestionable');
    }

    public function seo()
    {
        return $this->morphOne(SEO::class, 'subject');
    }
}
