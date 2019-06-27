<?php

namespace App;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia\HasMediaTrait;
use Spatie\MediaLibrary\HasMedia\Interfaces\HasMediaConversions;
use Laravel\Scout\Searchable;

class Place extends Model implements HasMediaConversions
{
    use Favouritable, Reviewable, HasMediaTrait, FilteredImageConversion, RecordsActivity, Searchable; //LocationTrait

    // protected $connection = 'mysql';

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
     * The relations to eager load on every query.
     *
     * @var array
     */
    protected $with = ['favourites', 'tags', 'media'];

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
        // return $this->toArray() + ['type' => 'places-to-go'];
        return [
            'title' => $this->title,
            'slug' => $this->slug,
            'categories' => $this->extractTags(),
            'type' => 'places-to-go'
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

    public function url($site)
    {
        return url($site . '/places-to-go/' . $this->slug);
    }

    function scopeFeatured($query, $number)
    {
        $activities = $query->with('tags')->get()->map(function ($place, $key) {
            return $place->tags;
        })->flatten(1)->unique('name')->filter(function ($value, $key) {
            return $value->featured == 1;
        })->all();

        return collect($activities)->take($number);
    }

    /**
     * Place belongs to Tags.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function tags()
    {
        return $this->morphToMany(Tag::class, 'taggables');
    }

    /**
     * Places morphs to many (many-to-many) .
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphToMany
     */
    public function adverts()
    {
        return $this->morphMany(Advertising::class, 'subject');
    }


    /**
     * Get all of the Place's reviews.
     */
    public function reviews()
    {
        return $this->morphMany(Review::class, 'subject')
                    ->whereNotNull('approved_at');
    }

    /**
     * Get all of the Place's suggestions.
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
