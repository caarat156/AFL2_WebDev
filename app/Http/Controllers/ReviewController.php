<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use App\Models\Review;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    public function index()
{
    $reviews = Review::where('user_id', Auth::id())->latest()->get();
    return view('user.review', compact('reviews'));
}

public function create()
{
    return view('user.createreview');
}

public function store(Request $request)
{
    $request->validate([
        'product_id' => 'nullable|exists:products,id',
        'rating' => 'required|integer|min:1|max:5',
        'comment' => 'required|string',
    ]);

    Review::create([
        'product_id' => $request->product_id,
        'user_id' => Auth::id(),
        'name' => Auth::user()->name,
        'rating' => $request->rating,
        'comment' => $request->comment,
    ]);

    return redirect()->route('user.reviews.index')->with('success', 'Review added!');
}
}