<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cart;
use App\Models\Product;
use App\Models\Wishlist;
use Carbon\Carbon;

class CartController extends Controller
{
    public function addtocartwish($wishlist_id)
    {
        $vendor_id = Product::find(Wishlist::find($wishlist_id)->product_id)->user_id;
        $wish_cart_check = Cart::where('user_id', auth()->id())->where('product_id', Wishlist::find($wishlist_id)->product_id)->exists();
        if ($wish_cart_check) {
            Cart::where('user_id', auth()->id())->where('product_id', Wishlist::find($wishlist_id)->product_id)->increment('amount', 1);
        }
        else {
            Cart::insert([
                'user_id' => auth()->id(),
                'vendor_id' => $vendor_id,
                'product_id' => Wishlist::find($wishlist_id)->product_id
            ]);
        }
        Wishlist::find($wishlist_id)->delete();
        return back();
    }

    public function addtocart(Request $request, $product_id)
    {
        $cart_check = Cart::where('user_id', auth()->id())->where('product_id', $product_id)->exists();
        if ($cart_check) {
            Cart::where('user_id', auth()->id())->where('product_id', $product_id)->increment('amount', $request->qtybutton);
        }
        else {
            Cart::insert([
                'user_id' => auth()->id(),
                'vendor_id' => Product::find($product_id)->user_id,
                'product_id' => $product_id,
                'amount' => $request->qtybutton,
                'created_at' => Carbon::now()
            ]);
        }
        return back();
    }

    public function cart()
    {
        return view('frontend.cart');
    }

    public function clearshoppingcart($user_id)
    {
        Cart::where('user_id', $user_id)->delete();
        return back();
    }

    public function cartremove($cart_id)
    {
        Cart::find($cart_id)->delete();
        return back();
    }
}
