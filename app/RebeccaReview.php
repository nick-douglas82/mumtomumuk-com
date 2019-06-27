<?php

namespace App;

use App\HasTags;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Request;
use Spatie\MediaLibrary\HasMedia\HasMediaTrait;
use Spatie\MediaLibrary\HasMedia\Interfaces\HasMediaConversions;
use Laravel\Scout\Searchable;

class RebeccaReview extends Model implements HasMediaConversions
{
    use HasMediaTrait, PostImageRRConversion, Commentable, Searchable; //LocationTrait

    // protected $connection = 'mysql';

    /**
     * The relations to eager load on every query.
     *
     * @var array
     */
    protected $with = ['category', 'media', 'category'];

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
        // return $this->toArray() + ['type' => 'blog/rebecca-reviews'];
        return [
            'title' => $this->title,
            'slug' => $this->slug,
            'category' => $this->extractTags(),
            'type' => 'blog/rebecca-reviews'
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

    function scopeFeatured($query, $number)
    {
        return $query->where('featured', 1)->limit($number)->get();
    }

    function scopeCategories($query)
    {
        return $query->with('category')->get()->map(function ($post, $key) {
            return $post->category;
        })->flatten(1)->unique('name');
    }

    public function url($site)
    {
        return url($site . '/blog/rebecca-reviews/' . $this->slug);
    }

    public function reviewDate()
    {
        return $this->created_at->format('d F Y');
    }

    public function reviewRatings()
    {
        return unserialize($this->ratings);
    }

    /**
     * Rebecca Review morphs to many (many-to-many) .
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphToMany
     */
    public function adverts()
    {
        return $this->morphMany(Advertising::class, 'subject');
    }

    /**
     * RebeccaReview belongs to Category.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * RebeccaReview belongs to User.
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
