<?php

namespace App\Http\Controllers;

use App\Models\Review;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public function index()
    {
        return view('homeumum');
    }

    public function userHome()
    {
        $bestSellers = Product::whereIn('id', [1, 9, 13, 8])->get();
        $reviews = Review::latest()->paginate(6);

        return view('user.home', compact('bestSellers', 'reviews'));
    }

    public function adminHome()
    {
        return view('admin.adminproduct', [
            'user' => Auth::user()
        ]);
    }
}
