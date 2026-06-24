<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Payment;
use Illuminate\Support\Facades\Auth;

class PaymentController extends Controller
{
    public function index()
    {
        $payments = Payment::whereHas('booking', function ($q) {
            $q->where('user_id', Auth::id());
        })->get();

        return view('user.payments.index', compact('payments'));
    }
}