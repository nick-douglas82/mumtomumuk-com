<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Suggestion extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'suggestionable_id', 'user_id', 'suggestionable_type'
    ];

    /**
     * The relations to eager load on every query.
     *
     * @var array
     */
    protected $with = ['place', 'directory'];

    /**
     * Get all of the owning suggestionable models.
     */
    public function suggestionable()
    {
        return $this->morphTo();
    }

    /**
     * Suggestion belongs to Place.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function place()
    {
        return $this->belongsTo(Place::class, 'related_id');
    }

    /**
     * Suggestion belongs to Place.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function directory()
    {
        return $this->belongsTo(Directory::class, 'related_id');
    }

    /**
     * Suggestion belongs to Event.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function event()
    {
        return $this->belongsTo(Event::class, 'related_id');
    }

    /**
     * Suggestion belongs to After School Club.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function afterschoolclub()
    {
        return $this->belongsTo(AfterSchoolClub::class, 'related_id');
    }

    /**
     * Suggestion belongs to Baby Toddler Group.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function babytoddlergroup()
    {
        return $this->belongsTo(BabyToddlerGroup::class, 'related_id');
    }
}
