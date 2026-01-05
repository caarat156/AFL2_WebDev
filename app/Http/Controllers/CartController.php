<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Models\Orders;
use App\Models\Order_Items;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;


class CartController extends Controller
{
    // Display cart items
    public function index()
    {
        $cartItems = Cart::where('user_id', auth()->id())
            ->with('product')
            ->get();
        
        return view('user.cart', compact('cartItems'));
    }

    // Add product to cart
    public function add(Request $request)
    {
        $validated = $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1',
        ]);

        $existingCart = Cart::where('user_id', auth()->id())
            ->where('product_id', $validated['product_id'])
            ->first();

        if ($existingCart) {
            // Jika produk sudah ada di cart, tambah quantity
            $existingCart->update([
                'quantity' => $existingCart->quantity + $validated['quantity'],
            ]);
        } else {
            // Jika belum ada, buat entry baru
            Cart::create([
                'user_id' => auth()->id(),
                'product_id' => $validated['product_id'],
                'quantity' => $validated['quantity'],
            ]);
        }

        return redirect()->route('user.cart')
            ->with('success', 'Product added to cart successfully!');
    }

    // Remove item from cart
 // Ubah parameternya jadi $id biasa, jangan (Cart $cart)
public function remove($id)
{
    // 1️⃣ Pastikan User Login
    if (!auth()->check()) {
        abort(403);
    }

    // 2️⃣ Cari Manual berdasarkan 'cart_id'
    $cart = Cart::where('cart_id', $id)
        ->where('user_id', auth()->id()) // Pastikan punya dia sendiri
        ->first();

    // 3️⃣ Cek Ketemu Gak?
    if (!$cart) {
        return back()->with('error', 'Barang tidak ditemukan atau bukan milikmu.');
    }

    // 4️⃣ Hapus
    $cart->delete();

    return back()->with('success', 'Item berhasil dihapus dari keranjang.');
}
    

    public function update(Request $request, $id)
{
    $request->validate([
        'quantity' => 'required|integer|min:1'
    ]);

    Cart::where('id', $id)
        ->where('user_id', auth()->id())
        ->update([
            'quantity' => $request->quantity
        ]);

    return back();
}

    

    // public function checkout(Request $request)
    // {
    //     $request->validate([
    //         'selected_items' => 'required|array|min:1',
    //         'selected_items.*' => 'required|integer|exists:carts,id',
    //     ]);

    //     $selectedItems = $request->selected_items;

    //     $cartItems = Cart::whereIn('id', $selectedItems)
    //         ->where('user_id', auth()->id())
    //         ->with('product')
    //         ->get();

    //     // Debug: Check if items exist
    //     if ($cartItems->isEmpty()) {
    //         return redirect()->route('user.cart')
    //             ->with('error', 'No items selected for checkout');
    //     }

    //     // Calculate total untuk verification di view
    //     $total = $cartItems->sum(function($item) {
    //         return ($item->product->price_2025 ?? $item->product->price_2024) * $item->quantity;
    //     });

    //     return view('user.checkout', compact('cartItems', 'total'));
    // }

    public function checkout(Request $request)
    {
        // 1️⃣ VALIDASI
        $request->validate([
            'selected_items' => 'required|array|min:1',
            'selected_items.*' => 'required|integer|exists:cart,cart_id',
        ]);
    
        // 2️⃣ AMBIL DATA CART
        $cartItems = Cart::with('product')
            ->whereIn('cart_id', $request->selected_items)
            ->where('user_id', auth()->id())
            ->get();
    
        if ($cartItems->isEmpty()) {
            return redirect()->route('user.cart')
                ->with('error', 'Cart items not found');
        }
    
        // 3️⃣ HITUNG TOTAL
        $total = $cartItems->sum(function ($item) {
            return ($item->product->price_2025 ?? $item->product->price_2024) * $item->quantity;
        });
    
        // 4️⃣ DATABASE TRANSACTION
        $order = null;
    
        DB::transaction(function () use ($cartItems, $total, &$order) {
            
            // --- STEP A: BIKIN KEPALA NOTA (ORDER) ---
            // Kita pakai cara MANUAL (new Orders) supaya 'order_date' DIJAMIN MASUK
            $order = Orders::create([
                'midtrans_order_id' => 'PROD-' . uniqid(),
                'user_id' => auth()->id(),
                'total_price' => $total,
                'payment_status' => 'pending',
                'status' => 'on process',
                'order_date' => now(), // <--- TAMBAHKAN BARIS INI
            ]);
    
            // --- STEP B: BIKIN DAFTAR BARANG (ORDER ITEMS) ---
            foreach ($cartItems as $item) {
                Order_Items::create([
                    'order_id'   => $order->order_id, // Ambil ID dari order yg baru dibuat di atas
                    'product_id' => $item->product_id,
                    'quantity'   => $item->quantity,
                    'unit_price' => ($item->product->price_2025 ?? $item->product->price_2024),
                    'sub_total'  => $item->quantity * ($item->product->price_2025 ?? $item->product->price_2024),
                ]);
            }
            
        });
    
        return view('user.checkout', compact('cartItems', 'total', 'order'));
    }

}