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
        $request->validate([
            'order_id' => 'required',
            'payment_method' => 'required|string'
        ]);
    
        $order = Orders::findOrFail($request->order_id);
    
        Config::$serverKey = config('midtrans.server_key');
        Config::$isProduction = false;
        Config::$isSanitized = true;
        Config::$is3ds = true;
    
        $enabledPaymentsMap = [
            'gopay' => ['gopay'],
            'shopeepay' => ['shopeepay'],
            'bank_transfer' => ['bank_transfer'],
            'credit_card' => ['credit_card'],
        ];
    
        $enabledPayments =
            $enabledPaymentsMap[$request->payment_method] ?? [];
    
        $order->update([
            'payment_method' => $request->payment_method
        ]);
    
        $params = [
            'transaction_details' => [
                'order_id' => 'ORD-' . $order->order_id,
                'gross_amount' => $order->total_price,
            ],
            'customer_details' => [
                'first_name' => Auth::user()->name,
                'email' => Auth::user()->email,
            ],
            'enabled_payments' => $enabledPayments,
            'callbacks' => [
                'finish' => route('payment.finish'),
            ],
        ];
    
        $snapToken = Snap::getSnapToken($params);
    
        return response()->json([
            'snap_token' => $snapToken
        ]);
    }
    

    public function finish(Request $request)
{
    $orderId = $request->order_id;
    $transactionStatus = $request->transaction_status;

    if ($transactionStatus === 'settlement') {
        Orders::where('order_id', $orderId)->update([
            'payment_status' => 'paid'
        ]);
    }

    return redirect()->route('user.home')
    ->with('success', 'Pembayaran berhasil 🎉');
}

    

    // ================= MIDTRANS CALLBACK =================
    public function callback(Request $request)
    {
        $serverKey = config('midtrans.server_key');

        // ✅ VALIDASI SIGNATURE (WAJIB)
        $signatureKey = hash(
            'sha512',
            $request->order_id .
            $request->status_code .
            $request->gross_amount .
            $serverKey
        );

        if ($signatureKey !== $request->signature_key) {
            return response()->json(['message' => 'Invalid signature'], 403);
        }

        $orderId = str_replace('ORD-', '', $request->order_id);
        $order = Orders::find($orderId);

        if (!$order) {
            return response()->json(['message' => 'Order not found'], 404);
        }

        if (in_array($request->transaction_status, ['settlement', 'capture'])) {
            $order->update([
                'payment_status' => 'paid',
                'payment_date' => now(),
                'payment_amount' => $request->gross_amount,
                'payment_method' => $request->payment_type,
                'status' => 'completed'
            ]);

            // 🧹 clear cart user
            Cart::where('user_id', $order->user_id)->delete();
        }

        return response()->json(['message' => 'Callback processed']);
    }
}
