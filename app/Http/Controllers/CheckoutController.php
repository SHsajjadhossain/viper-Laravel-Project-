<?php

namespace App\Http\Controllers;

use App\Models\City;
use App\Models\Country;
use Illuminate\Http\Request;

class CheckoutController extends Controller
{
    public function checkout()
    {
        if (strpos(url()->previous(), 'cart') || strpos(url()->previous(), 'checkout')) {
            return view('frontend.checkout', [
                'countries' => Country::where('status', 'active' )->get(['id', 'name'])
            ]);
        }
        else {
            abort(404);
        }

    }
    public function checkout_post(Request $request)
    {
        $request->validate([
            '*' => 'required',
            'order_notes' => 'nullable'
        ]);
    }

    public function get_city_list(Request $request)
    {
        $string_to_show = "<option value=''>-Select a city-</option>";
        foreach (City::where('country_id', $request->country_id)->get(['id', 'name']) as $city) {
            $string_to_show .= "<option value='$city->id'>$city->name</option>";
        }
        echo $string_to_show;
    }
}
