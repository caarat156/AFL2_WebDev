<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EmailVerificationNotificationController extends Controller
{
    /**
     * Send a new email verification notification.
     */
    public function store(Request $request): RedirectResponse 
    {
        if (Auth::user()->hasVerifiedEmail()) { 
            if (Auth::user()->role === 'admin') {
                return redirect()->route('admin.product'); 
            } else {
                return redirect()->route('user.home');
            }
        }
        
        Auth::user()->sendEmailVerificationNotification();

        $request->user()->sendEmailVerificationNotification(); 

        return back()->with('status', 'verification-link-sent'); 
    }
}