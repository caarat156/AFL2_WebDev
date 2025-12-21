<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Product;
use Illuminate\Http\Request;

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
    public function remove(Cart $cart)
    {
        // Pastikan hanya user yang punya cart dapat menghapus
        if ($cart->user_id !== auth()->id()) {
            abort(403, 'Unauthorized');
        }

        $cart->delete();

        return redirect()->route('user.cart')
            ->with('success', 'Product removed from cart!');
    }

    public function update(Request $request, Cart $cart)
    {
        if ($cart->user_id !== auth()->id()) {
            abort(403, 'Unauthorized');
        }

        $validated = $request->validate([
            'quantity' => 'required|integer|min:1',
        ]);

        $cart->update($validated);

        // ✅ Selalu return JSON untuk AJAX request
        if ($request->expectsJson() || $request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Quantity updated!',
                'cart' => $cart
            ]);
        }

        return redirect()->route('user.cart')
            ->with('success', 'Quantity updated!');
    }

    public function checkout(Request $request)
    {
        $selectedItems = $request->input('selected_items', []);
        
        if (empty($selectedItems)) {
            return redirect()->back()->with('error', 'Please select at least one item');
        }
        
        // Ambil data item yang dipilih
        $cartItems = Cart::whereIn('id', $selectedItems)
            ->where('user_id', auth()->id())
            ->with('product')
            ->get();
        
        // Redirect ke halaman checkout
        return view('user.checkout', compact('cartItems'));
    }
}