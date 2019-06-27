<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Request;
use Spatie\MediaLibrary\HasMedia\HasMediaTrait;
use Spatie\MediaLibrary\HasMedia\Interfaces\HasMediaConversions;
use Laravel\Scout\Searchable;

class HolidayIdeas extends Model implements HasMediaConversions
{
    use HasMediaTrait, PostImageConversion, Commentable, Searchable; //LocationTrait

    // protected $connection = 'mysql';

    /**
     * Fields that can be mass assigned.
     *
     * @var array
     */
    protected $fillable = ['user_id', 'body'];

    /**
     * The relations to eager load on every query.
     *
     * @var array
     */
    protected $with = ['category', 'media'];

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
        // return $this->toArray() + ['type' => 'holiday-ideas'];
        return [
            'title'      => $this->title,
            'slug'       => $this->slug,
            'categories' => $this->extractTags(),
            'type'       => 'holiday-ideas'
        ];
    }

    /**
     * Return an array of tag names to add to indexable data.
     *
     * @return array
     */
    public function extractTags()
    {
        return $this->category->name;
    }

    function scopeCategories($query)
    {
        return $query->with('category')->get()->map(function ($holiday, $key) {
            return $holiday->category;
        })->flatten(1)->unique('name');
    }

    public function url($site)
    {
        return url($site . '/blog/posts/' . $this->slug);
    }

    public function postDate()
    {
        return $this->created_at->format('d F Y');
    }

    /**
     * HolidayIdeas morphs to many (many-to-many) .
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphToMany
     */
    public function adverts()
    {
        return $this->morphMany(Advertising::class, 'subject');
    }

    /**
     * Holiday ideas belongs to Category.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * Post belongs to Author (user).
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function seo()
    {
        return $this->morphOne(SEO::class, 'subject');
    }
}
