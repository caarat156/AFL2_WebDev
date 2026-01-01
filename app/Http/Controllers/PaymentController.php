<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Midtrans\Snap;
use Midtrans\Config;

class PaymentController extends Controller
{
    public function createSnapToken(Request $request)
    {
        $request->validate([
            'order_id' => 'required',
            'amount' => 'required|numeric|min:1',
            'name' => 'required',
            'email' => 'required|email',
        ]);

        Config::$serverKey = config('midtrans.server_key');
        Config::$isProduction = config('midtrans.is_production');
        Config::$isSanitized = true;
        Config::$is3ds = true;

        $params = [
            'transaction_details' => [
                'order_id' => $request->order_id,
                'gross_amount' => (int) $request->amount,
            ],
            'customer_details' => [
                'first_name' => $request->name,
                'email' => $request->email,
            ],
        ];

        $snapToken = Snap::getSnapToken($params);

        return response()->json([
            'snap_token' => $snapToken
        ]);
    }
}

