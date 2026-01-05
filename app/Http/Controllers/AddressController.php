<?php

namespace App\Http\Controllers;

use App\Models\Address;
use Illuminate\Http\Request;

class AddressController extends Controller
{
    // ================= SET DEFAULT =================
    public function setDefault($id)
    {
        // 1. Reset semua alamat user ini jadi NON-DEFAULT (0)
        Address::where('user_id', auth()->id())
            ->update(['is_default' => 0]);

        // 2. Set alamat yang dipilih jadi DEFAULT (1)
        Address::where('address_id', $id)
            ->where('user_id', auth()->id())
            ->update(['is_default' => 1]);

        return back()->with('success', 'Alamat utama berhasil diubah.');
    }

    // ================= DELETE =================
    public function destroy($id)
    {
        // Cari manual biar pasti ketemu
        $address = Address::where('address_id', $id)
            ->where('user_id', auth()->id())
            ->first();

        if ($address) {
            $address->delete();
            return back()->with('success', 'Alamat berhasil dihapus.');
        }

        return back()->with('error', 'Alamat tidak ditemukan.');
    }

    // ================= EDIT (UPDATE) =================
    public function update(Request $request, $id)
    {
        $request->validate([
            'recipient_name' => 'required|string|max:255',
            'phone_number'   => 'required|string|max:20',
            'address_line'   => 'required|string',
            'city'           => 'required|string',
            'province'       => 'required|string',
            'postal_code'    => 'required|string',
        ]);

        $address = Address::where('address_id', $id)
            ->where('user_id', auth()->id())
            ->first();

        if (!$address) {
            return back()->with('error', 'Alamat tidak ditemukan.');
        }

        $address->update([
            'recipient_name' => $request->recipient_name,
            'phone_number'   => $request->phone_number,
            'address_line'   => $request->address_line,
            'city'           => $request->city,
            'province'       => $request->province,
            'postal_code'    => $request->postal_code,
        ]);

        return back()->with('success', 'Alamat berhasil diperbarui.');
    }
}