<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;
use Illuminate\Support\Facades\Storage;

class User extends Authenticatable
{
    use HasApiTokens, Notifiable;

    protected $connection = 'mysql';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'slug', 'email', 'password', 'provider', 'provider_id', 'avatar_path'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token', 'email', 'provider', 'provider_id', 'created_at', 'updated_at'
    ];

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
     * If there is an avatar path in DB from social media then return it,
     * otherwise grab the default placeholder
     *
     * @return string
     */
    public function avatar() {
        return $this->avatar_path ? Storage::url($this->avatar_path) : '/images/svg/avatar_default.svg';
    }

    /**
     * Split the user's name and return the first name
     *
     * @return string
     */
    public function firstName()
    {
        $name = explode(' ', $this->name);

        return $name[0];
    }

    /**
     * Split the user's name and return the last name
     *
     * @return string
     */
    public function lastName()
    {
        $name = explode(' ', $this->name);

        if ( count($name) > 1 ) {
            return $name[1];
        }

        return '';
    }

    /**
     * Decide if the user is logged in using a social profile or standard username/password.
     *
     * @return boolean
     */
    public function usingSocialAccount()
    {
        return ( ! is_null($this->provider) && ! is_null($this->provider_id) ) ? true : false;
    }

    /**
     * User has many Activity.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function activity()
    {
        return $this->hasMany(Activity::class);
    }

    /**
     * User has many Activity.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function favourites()
    {
        return $this->hasMany(Favourite::class);
    }

    /**
     * User has many Reviews.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    /**
     * User has many Rebeccareviews.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function rebeccareviews()
    {
        return $this->hasMany(RebeccaReview::class);
    }

    /**
     * User has many Posts.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function posts()
    {
        return $this->hasMany(Post::class);
    }
}
