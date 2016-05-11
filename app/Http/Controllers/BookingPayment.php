<?php

namespace App\Http\Controllers;

use App\Models\PaymentType;
use Illuminate\Http\Request;

use App\Http\Requests;

class BookingPayment extends Controller
{

    public function index()
    {
        $paymentTypes = PaymentType::orderBy('id', 'DESC')->get();

        return view('booking.payment', [
            'paymentTypes' => $paymentTypes
        ]);
    }
}
