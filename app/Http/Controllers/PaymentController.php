<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Midtrans\Snap;
use Midtrans\Config;
use App\Models\Orders;
use App\Models\Cart;
use Midtrans\Notification;
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

    public function finish(Request $request)
    {
        dd($request->all());

        $orderId = str_replace('ORD-', '', $request->order_id);
    
        if ($request->transaction_status === 'settlement'
            || $request->transaction_status === 'capture') {
    
            Orders::where('order_id', $orderId)->update([
                'payment_status' => 'paid',
                'status' => 'completed',
            ]);
        }
    
        return redirect()
            ->route('user.profile')
            ->with('success', 'Pembayaran berhasil 🎉');
    }
    


public function notificationHandler(Request $request)
{
    Config::$serverKey = config('midtrans.server_key');
    Config::$isProduction = config('midtrans.is_production');

    $notification = new Notification();

    $orderId = $notification->order_id;
    $transactionStatus = $notification->transaction_status;
    $fraudStatus = $notification->fraud_status;

    $order = Orders::where('order_id', $orderId)->first();

    if (!$order) {
        return response()->json(['message' => 'Order not found'], 404);
    }

    if (
        $transactionStatus == 'capture' && $fraudStatus == 'accept' ||
        $transactionStatus == 'settlement'
    ) {
        $order->payment_status = 'paid';
    } elseif ($transactionStatus == 'pending') {
        $order->payment_status = 'pending';
    } elseif (in_array($transactionStatus, ['deny', 'cancel', 'expire'])) {
        $order->payment_status = 'failed';
    }

    $order->save();

    return response()->json(['message' => 'OK']);
}

    public function callback(Request $request)
    {
        // 🔐 CONFIG MIDTRANS
        Config::$serverKey = config('midtrans.server_key');
        Config::$isProduction = config('midtrans.is_production');

        // 📩 TERIMA NOTIFIKASI
        $notification = new Notification();

        $transactionStatus = $notification->transaction_status;
        $paymentType = $notification->payment_type;
        $orderId = $notification->order_id;
        $fraudStatus = $notification->fraud_status;

        // 🔍 CARI ORDER
        $order = Orders::where('order_id', $orderId)->first();

        if (!$order) {
            return response()->json(['message' => 'Order not found'], 404);
        }

        // 🧠 LOGIKA STATUS
        if ($transactionStatus == 'settlement' || $transactionStatus == 'capture') {
            $order->payment_status = 'paid';
        } elseif ($transactionStatus == 'pending') {
            $order->payment_status = 'pending';
        } elseif (in_array($transactionStatus, ['expire', 'cancel', 'deny'])) {
            $order->payment_status = 'failed';
        }

        $order->payment_method = $paymentType;
        $order->save();

        return response()->json(['message' => 'Callback processed']);
    }




}
