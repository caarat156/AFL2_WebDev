<?php

namespace App\Http\Controllers;

use App\Models\Address;
use Illuminate\Http\Request;

class AddressController extends Controller
{
    public function index()
    {
        $addresses = auth()->user()->addresses;
        return view('user.addresses.index', compact('addresses'));
    }

    public function create()
    {
        return view('user.addresses.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'label' => 'nullable|string|max:50',
            'recipient_name' => 'required|string|max:100',
            'phone' => 'required|string|max:20',
            'street' => 'required|string',
            'city' => 'required|string|max:50',
            'province' => 'required|string|max:50',
            'postal_code' => 'required|string|max:10',
            'is_default' => 'boolean',
        ]);

        if ($validated['is_default'] ?? false) {
            auth()->user()->addresses()->update(['is_default' => false]);
        }

        auth()->user()->addresses()->create($validated);

        // Check if coming from cart
        $from = $request->query('from', 'addresses');
        
        if ($from === 'cart') {
            return redirect()->route('user.cart')
                ->with('success', 'Address added successfully!');
        }

        return redirect()->route('user.addresses')
            ->with('success', 'Address added successfully!');
    }

    public function edit(Address $address)
    {
        if ($address->user_id !== auth()->id()) {
            abort(403, 'Unauthorized');
        }
        return view('user.addresses.edit', compact('address'));
    }

    public function update(Request $request, Address $address)
    {
        if ($address->user_id !== auth()->id()) {
            abort(403, 'Unauthorized');
        }

        $validated = $request->validate([
            'label' => 'nullable|string|max:50',
            'recipient_name' => 'required|string|max:100',
            'phone' => 'required|string|max:20',
            'street' => 'required|string',
            'city' => 'required|string|max:50',
            'province' => 'required|string|max:50',
            'postal_code' => 'required|string|max:10',
            'is_default' => 'boolean',
        ]);

        if ($validated['is_default'] ?? false) {
            auth()->user()->addresses()->update(['is_default' => false]);
        } else {
            $validated['is_default'] = false;
        }

        $address->update($validated);

        // Check if coming from cart
        $from = $request->query('from', 'addresses');
        
        if ($from === 'cart') {
            return redirect()->route('user.cart')
                ->with('success', 'Address updated successfully!');
        }

        return redirect()->route('user.addresses')
            ->with('success', 'Address updated successfully!');
    }

    public function destroy(Address $address)
    {
        if ($address->user_id !== auth()->id()) {
            abort(403, 'Unauthorized');
        }
        $address->delete();

        return redirect()->route('user.addresses')
            ->with('success', 'Address deleted!');
    }

    public function setDefault(Address $address)
    {
        if ($address->user_id !== auth()->id()) {
            abort(403, 'Unauthorized');
        }
        
        auth()->user()->addresses()->update(['is_default' => false]);
        $address->update(['is_default' => true]);

        return back()->with('success', 'Default address updated!');
    }
}
