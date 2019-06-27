<?php
namespace App;

use App\Activity;
use App\Comment;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

trait Commentable
{
    public function comments()
    {
        return $this->morphMany(Comment::class, 'subject');
    }

    /**
     * Create a comment on the current item.
     *
     * @return Model
     */
    public function comment($request, $subject)
    {
        $comment               = new Comment;
        $comment->user_id      = auth()->id();
        $comment->body         = $request['body'];
        $comment->subject_id   = $subject->id;
        $comment->subject_type = get_class($subject);

        $comment->save();

        $comment->recordDirectActivity($subject);
    }
}
