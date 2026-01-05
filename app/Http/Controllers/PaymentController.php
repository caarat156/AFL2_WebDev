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

    // ⬇️ ini MIDTRANS order id
    $midtransOrderId = $request->midtrans_order_id;

    $order = Orders::where('midtrans_order_id', $midtransOrderId)->firstOrFail();

    $params = [
        'transaction_details' => [
            'order_id' => $order->midtrans_order_id, // ✅ WAJIB
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
        $midtransOrderId = $request->order_id; // dari Midtrans

        if (
            $request->transaction_status === 'settlement' ||
            $request->transaction_status === 'capture'
        ) {
            Orders::where('midtrans_order_id', $midtransOrderId)->update([
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

    $order = Orders::where('midtrans_order_id', $orderId)->first();

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

    // Jangan lupa import Model di paling atas file:
// use App\Models\WorkshopRegistration;

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

    // 🔍 LOGIKA PENCARIAN GANDA (ORDER ATAU WORKSHOP?)
    $targetTransaction = null;
    $type = '';

    // Cek apakah ini Order Produk?
    $order = Orders::where('midtrans_order_id', $orderId)->first();
    
    if ($order) {
        $targetTransaction = $order;
        $type = 'product';
    } else {
        // Kalau bukan Produk, Cek apakah ini Workshop?
        $workshop = \App\Models\WorkshopRegistration::where('midtrans_order_id', $orderId)->first();
        if ($workshop) {
            $targetTransaction = $workshop;
            $type = 'workshop';
        }
    }

    // Kalau di kedua tabel gak ketemu, balikin 404
    if (!$targetTransaction) {
        return response()->json(['message' => 'Order not found in both tables'], 404);
    }

    // 🧠 LOGIKA STATUS (Sama untuk keduanya)
    if ($transactionStatus == 'settlement' || $transactionStatus == 'capture') {
        $targetTransaction->payment_status = 'paid';
    } elseif ($transactionStatus == 'pending') {
        $targetTransaction->payment_status = 'pending';
    } elseif (in_array($transactionStatus, ['expire', 'cancel', 'deny'])) {
        $targetTransaction->payment_status = 'failed';
    }

    // Simpan Payment Method (Jika kolomnya ada di tabel workshop)
    // Pastikan tabel workshop_registration punya kolom 'payment_method'
    $targetTransaction->payment_method = $paymentType;
    
    $targetTransaction->save();

    return response()->json(['message' => 'Callback processed for ' . $type]);
}

    public function showProfile()
    {
        $user = Auth::user();
    
        // History produk
        $orders = $user->orders()->with('items.product')->get();
    
        // History workshop
        $workshopRegistrations = $user->workshopRegistrations()->with('workshop')->get();
    
        return view('user.profile', compact('orders', 'workshopRegistrations'));
    }


}
