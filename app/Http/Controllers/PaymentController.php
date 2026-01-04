<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Midtrans\Snap;
use Midtrans\Config;
use App\Models\Orders;
use App\Models\Cart;
use Illuminate\Support\Facades\Auth;



class PaymentController extends Controller
{
    // ================= SNAP TOKEN =================


    public function createSnapToken(Request $request)
    {
        Config::$serverKey = config('midtrans.server_key');
        Config::$isProduction = config('midtrans.is_production');
        Config::$isSanitized = true;
        Config::$is3ds = true;
    
        $orderId = $request->order_id;
    
        $order = Orders::where('order_id', $orderId)->firstOrFail();
    
        $params = [
            'transaction_details' => [
                'order_id' => $order->order_id,
                'gross_amount' => $order->total_price,
            ],
            'customer_details' => [
                'first_name' => auth()->user()->name,
                'email' => auth()->user()->email,
            ],
        ];
    
        $snapToken = Snap::getSnapToken($params);
    
        return response()->json([
            'snap_token' => $snapToken
        ]);
    }

}
