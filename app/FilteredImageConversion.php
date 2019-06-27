<?php

namespace App;

use Spatie\Image\Manipulations;
use Spatie\MediaLibrary\Media as BaseMedia;

trait FilteredImageConversion {

    public function registerMediaConversions(BaseMedia $media = null)
    {
        $this->addMediaConversion('listing')
              ->nonQueued()
              ->sharpen(10)
              ->crop(Manipulations::CROP_TOP_LEFT, 544, 440);

        $this->addMediaConversion('post')
              ->nonQueued()
              ->sharpen(10)
              ->crop(Manipulations::CROP_TOP_LEFT, 468, 256);
    }
}
