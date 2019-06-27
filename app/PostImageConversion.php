<?php

namespace App;

use Spatie\Image\Manipulations;
use Spatie\MediaLibrary\Media as BaseMedia;

trait PostImageConversion {

    public function registerMediaConversions(BaseMedia $media = null)
    {
        $this->addMediaConversion('listing')
             ->nonQueued()
             ->sharpen(10)
             ->crop(Manipulations::CROP_TOP_LEFT, 380, 217);

        $this->addMediaConversion('post')
             ->nonQueued()
             ->sharpen(10)
             ->crop(Manipulations::CROP_TOP_LEFT, 749, 384);

        $this->addMediaConversion('og_meta')
             ->width(1200)
             ->height(630)
             ->nonQueued()
             ->performOnCollections('og_meta');

        $this->addMediaConversion('twitter_meta')
             ->width(1024)
             ->height(512)
             ->nonQueued()
             ->performOnCollections('twitter_meta');
    }
}
