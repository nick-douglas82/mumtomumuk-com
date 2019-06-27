<?php

namespace App;

use App\MultiTenancy\MultiTenancy;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{

    /**
     * Category has many Rebeccareviews.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function rebeccareviews()
    {
        return $this->hasMany(RebeccaReview::class);
    }

    /**
     * Category has many Posts.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function posts()
    {
        return $this->hasMany(Post::class);
    }

    /**
     * Category has many holidayideas.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function holidayideas()
    {
        return $this->hasMany(HolidayIdeas::class);
    }
}
