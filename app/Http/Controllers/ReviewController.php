<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\Review;
use Illuminate\Http\Request;
use App\Models\Product;

class ReviewController extends Controller
{
    public function index()
    {
        $reviews = Review::where('user_id', Auth::id())->latest()->get();
        return view('user.review', compact('reviews'));
    }

    public function create()
    {
        $products = Product::all();
        return view('user.createreview', compact('products'));
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

public function edit($id)
{
    $review = Review::where('id', $id)
        ->where('user_id', Auth::id()) 
        ->firstOrFail();

    $products = Product::all();
    return view('user.updatereview', compact('review', 'products'));
}

public function update(Request $request, $id)
{
    $review = Review::where('id', $id)
        ->where('user_id', Auth::id())
        ->firstOrFail();

    $request->validate([
        'product_id' => 'nullable|exists:products,id',
        'rating' => 'required|integer|min:1|max:5',
        'comment' => 'required|string',
    ]);

    $review->update([
        'product_id' => $request->product_id,
        'rating' => $request->rating,
        'comment' => $request->comment,
    ]);

    return redirect()->route('user.reviews.index')->with('success', 'Review updated!');
}

public function destroy($id)
{
    $review = Review::where('id', $id)
        ->where('user_id', Auth::id())
        ->firstOrFail();

    $review->delete();

    return redirect()->route('user.reviews.index')->with('success', 'Review deleted!');
}

}
