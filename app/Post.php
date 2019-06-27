<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Request;
use Spatie\MediaLibrary\HasMedia\HasMediaTrait;
use Spatie\MediaLibrary\HasMedia\Interfaces\HasMediaConversions;
use Laravel\Scout\Searchable;

class Post extends Model implements HasMediaConversions
{
    use HasMediaTrait, PostImageConversion, Commentable, Searchable; //LocationTrait

    // protected $connection = 'mysql';

    /**
     * The relations to eager load on every query.
     *
     * @var array
     */
    protected $with = ['category', 'media', 'category', 'tags'];

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
        // return $this->toArray() + ['type' => 'blog/posts'];
        return [
                'title'   => $this->title,
                'slug'    => $this->slug,
                'tags'    => $this->extractTags(),
                'type'    => 'blog/posts'
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
        return $query->with('category')->get()->map(function ($post, $key) {
            return $post->category;
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
     * Post morphs to many (many-to-many) .
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphToMany
     */
    public function adverts()
    {
        return $this->morphMany(Advertising::class, 'subject');
    }

    /**
     * Post belongs to Category.
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

    /**
     * Post belongs to Tags.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function tags()
    {
        return $this->morphToMany(Tag::class, 'taggables');
    }

    public function seo()
    {
        return $this->morphOne(SEO::class, 'subject');
    }
}
