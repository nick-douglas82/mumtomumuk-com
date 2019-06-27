<?php

namespace App;

use Spatie\Image\Manipulations;
use Spatie\MediaLibrary\Media as BaseMedia;

trait TagImageConversion {

    public function registerMediaConversions(BaseMedia $media = null)
    {
        $this->addMediaConversion('category_image')
              ->nonQueued()
              ->sharpen(10)
              ->crop(Manipulations::CROP_TOP_LEFT, 760, 322);
    }
}
