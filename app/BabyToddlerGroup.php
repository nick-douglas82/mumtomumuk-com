<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Spatie\MediaLibrary\HasMedia\HasMediaTrait;
use Spatie\MediaLibrary\HasMedia\Interfaces\HasMediaConversions;
use Laravel\Scout\Searchable;

class BabyToddlerGroup extends Model implements HasMediaConversions
{
    use Favouritable, Reviewable, HasMediaTrait, FilteredImageConversion, RecordsActivity, Searchable; //LocationTrait

    // protected $connection = 'mysql';

    /**
     * The relations to eager load on every query.
     *
     * @var array
     */
    protected $with = ['favourites', 'media'];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = ['isFavorited', 'averageRating'];

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
        // return $this->toArray() + ['type' => 'baby-toddler-groups'];
        return [
            'title'      => $this->title,
            'slug'       => $this->slug,
            'categories' => $this->extractTags(),
            'type'       => 'baby-toddler-groups'
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
        $endTime = $end->format('H:i');
        return $start->format('D, j M Y, H:i') . '-' . $endTime;
    }

    public function url($site)
    {
        return url($site . '/baby-toddler-groups/' . $this->slug);
    }

    /**
     * Baby Toddler Group morphs to many (many-to-many) .
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphToMany
     */
    public function adverts()
    {
        return $this->morphMany(Advertising::class, 'subject');
    }

    /**
     * Baby Toddler Group belongs to Tags.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function tags()
    {
        return $this->belongsToMany(Tag::class, 'taggables', 'taggables_id');
    }

    /**
     * Get all of the Baby Toddler Group's reviews.
     */
    public function reviews()
    {
        return $this->morphMany('App\Review', 'subject')
                    ->whereNotNull('approved_at');
    }

    /**
     * Get all of the Baby Toddler Group's suggestions.
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
