<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cart;
use App\Models\Product;
use App\Models\Wishlist;

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
}
