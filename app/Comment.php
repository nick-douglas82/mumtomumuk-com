<?php

namespace App;

use App\Activity;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use RecordsActivity;

    /**
     * Fields that can be mass assigned.
     *
     * @var array
     */
    protected $fillable = ['user_id', 'body'];

    /**
     * Serve the dates.
     *
     * @var array
     */
    protected $dates = ['created_at', 'updated_at', 'approved_at'];

    public function commentDate()
    {
        return $this->created_at->format('d F');
    }

    /**
     * Comment morphs to models in _type.
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphTo
     */
    public function commentable()
    {
        return $this->morphTo();
    }

    /**
     * Comment belongs to User.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
