<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\Media;
use Spatie\MediaLibrary\HasMedia\Interfaces\HasMediaConversions;
use Spatie\MediaLibrary\HasMedia\HasMediaTrait;

class SEO extends Model implements HasMediaConversions
{
    use HasMediaTrait;

    protected $guarded = [];

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'seo';

    public function registerMediaConversions(Media $media = null)
    {
        $this->addMediaConversion('og_image')
             ->width(1200)
             ->height(630);

        $this->addMediaConversion('twitter_image')
             ->width(1024)
             ->height(512);
    }

    /**
     * Get all of the owning seoable models.
     */
    public function seoable()
    {
        return $this->morphTo();
    }
}
