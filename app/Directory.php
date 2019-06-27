<?php

namespace App;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia\HasMediaTrait;
use Spatie\MediaLibrary\HasMedia\Interfaces\HasMediaConversions;
use Laravel\Scout\Searchable;

class Directory extends Model implements HasMediaConversions
{
    use Favouritable, Reviewable, HasMediaTrait, FilteredImageConversion, RecordsActivity, Searchable;

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
        return [
            'title'      => $this->title,
            'slug'       => $this->slug,
            'categories' => $this->extractTags(),
            'type'       => 'directory'
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

    public function url($site)
    {
        return url($site . '/directory/' . $this->slug);
    }

    /**
     * Scopes
     */


    public function scopeCloseTo(Builder $query, $latitude, $longitude, $distance)
    {
        return $query->whereRaw(
            "ST_Distance_Sphere(coordinates, POINT(?, ?)) * .000621371192 < ?",
            [ $latitude, $longitude, $distance ]
        );
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
     * Relationships
     */

    /**
     * Directory morphs to many (many-to-many) .
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphToMany
     */
    public function adverts()
    {
        return $this->morphMany(Advertising::class, 'subject');
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
     * Get all of the Directory's reviews.
     */
    public function reviews()
    {
        return $this->morphMany(Review::class, 'subject')
                    ->whereNotNull('approved_at');
    }

    /**
     * Get all of the Directory's suggestions.
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
