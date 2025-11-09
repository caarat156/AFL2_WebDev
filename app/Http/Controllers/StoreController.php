<?php

namespace App\Http\Controllers;

use App\Models\Store;
use Illuminate\Http\Request;

class StoreController extends Controller
{
    public function index()
    {
        $stores = Store::all(); // ambil semua data
        return view('/user/store', compact('stores'));
    }

    public function adminIndex()
    {
        return view('admin.adminstore');
    }
}
