<?php

namespace App;

use Spatie\Image\Manipulations;
use Spatie\MediaLibrary\Media as BaseMedia;

trait PostImageRRConversion {

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

        $this->addMediaConversion('homepage')
             ->nonQueued()
             ->sharpen(10)
             ->crop(Manipulations::CROP_TOP_LEFT, 370, 217);
    }
}
