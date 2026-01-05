<?php

namespace App\Http\Controllers;

use App\Models\Orders;
use Illuminate\Http\Request;

class AdminTransactionController extends Controller
{
    // Menampilkan Daftar Transaksi
    public function index()
{
    // Kita load 'user' DAN 'orderItems.product' sekaligus biar data di Modal lengkap
    $transactions = Orders::with(['user', 'orderItems.product'])
                    ->latest('order_date')
                    ->get();

    return view('admin.producttransaction', compact('transactions'));
}

    // Menampilkan Detail Transaksi (Barang apa aja yang dibeli)
    public function show($id)
    {
        $transaction = Orders::with(['user', 'orderItems.product'])
            ->where('order_id', $id)
            ->firstOrFail();

        return view('admin.producttransaction', compact('transaction'));
    }
}