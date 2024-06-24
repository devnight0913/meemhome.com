<?php

namespace App\Http\Controllers;

use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReviewController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'rating' => ['required', 'integer', 'min:0', 'max:5'],
            'comment' => ['required', 'string', 'max:2500'],
        ]);
        $review = new Review();
        $review->rating = $request->rating;
        $review->comment = $request->comment;
        $review->user_id = $request->user_id;
        $review->item_id = $request->item_id;
        $review->save();
        return response()->noContent();
    }
    public function edit(Request $request, Review $review)
    {
        $request->validate([
            'rating' => ['required', 'integer', 'min:0', 'max:5'],
            'comment' => ['required', 'string', 'max:2500'],
        ]);
        $review->rating = $request->rating;
        $review->comment = $request->comment;
        $review->save();
        return response()->noContent();
    }



    public function destroy(Request $request, Review $review)
    {
        if ($review->user->id == Auth::id() || Auth::user()->is_admin) {
            $review->delete();
            return  back()->with('success', 'Review has been deleted.');
        }
        return back();
    }
}
