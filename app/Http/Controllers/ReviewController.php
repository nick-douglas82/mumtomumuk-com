<?php

namespace App\Http\Controllers;

use App\Place;
use App\Review;
use App\Site;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;

class ReviewController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function store(Request $request, Place $place)
    {

        $review = Review::create([
            'user_id'       => auth()->id(),
            'reviewable_id' => $place->id,
            'body'          => $request->params['review'],
            'source'        => null,
            'reviewed_type' => get_class($place),
            'rating'        => $request->params['rating']
        ]);
    }

    public function update(Review $review)
    {
        if ($review->approved_at != '') {
            $review->approved_at = NULL;
        }
        else {
            $review->approved_at = Carbon::now();
        }

        $review->save();

        return Response::json([
            'success' => true
        ]);
    }

    public function allPending()
    {
        $reviews = Review::whereNull('approved_at')->with('subject')->get();

        return response()->json(['success' => $reviews], 200);
    }

    public function allApproved()
    {
        $reviews = Review::whereNotNull('approved_at')->with('subject')->get();

        return response()->json(['success' => $reviews], 200);
    }
}
