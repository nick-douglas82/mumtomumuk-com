<?php

namespace App;

use App\Activity;

use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    use RecordsActivity;

    protected $connection = 'milton_keynes';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'reviewable_id', 'user_id', 'body', 'source', 'reviewed_type', 'rating'
    ];

    /**
     * The relations to eager load on every query.
     *
     * @var array
     */
    protected $with = ['user'];

    /**
     * Serve the dates.
     *
     * @var array
     */
    protected $dates = ['created_at', 'updated_at', 'approved_at'];

    /**
     * Fetch the model that was favourited.
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphTo
     */
    public function subject()
    {
        return $this->morphTo();
    }

    /**
     * Review belongs to User.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Review belongs to Directory.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function directory()
    {
        return $this->belongsTo(Directory::class);
    }

    /**
     * Review belongs to Place.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function place()
    {
        return $this->belongsTo(Place::class);
    }

    /**
     * Review belongs to Afterschoolclub.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function afterschoolclub()
    {
        return $this->belongsTo(AfterSchoolClub::class);
    }

    /**
     * Review belongs to Babytoddlergroup.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function babytoddlergroup()
    {
        return $this->belongsTo(BabyToddlerGroup::class);
    }
}
