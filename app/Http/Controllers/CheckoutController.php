<?php

namespace App\Http\Controllers;

use App\Models\Country;
use Illuminate\Http\Request;

class CheckoutController extends Controller
{
    public function checkout()
    {
        if (strpos(url()->previous(), 'cart')) {
            return view('frontend.checkout', [
                'countries' => Country::get(['id', 'name'])
            ]);
        }
        else {
            abort(404);
        }

    }
    public function checkout_post(Request $request)
    {
        return $request;
    }
}
