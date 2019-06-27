<?php
namespace App;
use App\Activity;
use Illuminate\Database\Eloquent\Model;
trait Favouritable
{
    /**
     * Boot the trait.
     */
    protected static function bootFavouritable()
    {
        static::deleting(function ($model) {
            $model->favourites->each->delete();
        });
    }

    /**
     * A reply can be favourited.
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphMany
     */
    public function favourites()
    {
        return $this->morphMany(Favourite::class, 'subject');
    }

    /**
     * Favorite the current item.
     *
     * @return Model
     */
    public function favourite($subject)
    {
        $attributes = ['user_id' => auth()->id()];

        if (! $this->favourites()->where($attributes)->exists()) {
            $favourite               = new Favourite;
            $favourite->user_id      = auth()->id();
            $favourite->subject_id   = $subject->id;
            $favourite->subject_type = get_class($subject);

            $favourite->save();


            if (get_class($subject) == 'App\Comment' || get_class($subject) == 'App\Review') {
                return $favourite->recordRelatedActivity($subject);
            }

            return $favourite->recordDirectActivity($subject);
        }

    }

    /**
     * Unfavorite the current reply.
     */
    public function unfavourite($subject)
    {
        $attributes = ['user_id' => auth()->id()];
        $this->favourites()->where($attributes)->get()->each->delete();

        $subject->activity()->delete();
    }

    /**
     * Determine if the current reply has been favorited.
     *
     * @return boolean
     */
    public function isFavorited()
    {
        return $this->favourites->where('user_id', auth()->id())->count();
    }

    /**
     * Fetch the favorited status as a property.
     *
     * @return bool
     */
    public function getIsFavoritedAttribute()
    {
        return $this->isFavorited();
    }
}
