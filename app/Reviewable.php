<?php
namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

trait Reviewable
{

    public function createReview($request, $subject)
    {
        $review               = new Review;
        $review->user_id      = auth()->id();
        $review->body         = $request->params['review'];
        $review->rating       = $request->params['rating'];
        $review->subject_id   = $subject->id;
        $review->subject_type = get_class($subject);

        $review->save();

        // $review->recordActivity($review, $review);
        $review->recordDirectActivity($subject);
    }

    public function scopeApproved($query)
    {
        return $query->whereNotNull('approved_at');
    }

    public function scopeReviews($query)
    {
        return '';
        // return $query->with('reviews', function($q) {
        //     $q->where('rating', '=', '4');
        // });
    }

    /**
     * Determine the average rating of this reviewable item.
     *
     * @return boolean
     */
    public function averageRating()
    {
        return $this->reviews->where('approved_at', '!=', null)->avg('rating') == 0 ? 0 : round($this->reviews->where('approved_at', '!=', null)->avg('rating'));
    }

    /**
     * Fetch the average rating as a property.
     *
     * @return bool
     */
    public function getAverageRatingAttribute()
    {
        return $this->averageRating();
    }

    /**
     * Count of approved ratings of this reviewable item.
     *
     * @return boolean
     */
    public function ratingCount()
    {
        return $this->reviews->count();
    }

    /**
     * Fetch the rating count as a property.
     *
     * @return bool
     */
    public function getRatingCountAttribute()
    {
        return $this->ratingCount();
    }

    public function reviews()
    {
        return $this->morphMany(Review::class, 'subject');
    }
}
