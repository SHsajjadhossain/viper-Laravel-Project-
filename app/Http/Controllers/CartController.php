<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cart;
use App\Models\Coupon;
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
        if (Product::find($product_id)->product_quantity < $request->qtybutton) {
            return back()->with('stockout', 'Stock not availabe');
        }
        else {
            $cart_check = Cart::where('user_id', auth()->id())->where('product_id', $product_id)->exists();
            if ($cart_check) {
                if (Product::find($product_id)->product_quantity < (Cart::where('user_id', auth()->id())->where('product_id', $product_id)->first()->amount + $request->qtybutton)) {
                    return back()->with('stockout', 'Already exist in cart');
                }
                else {
                    Cart::where('user_id', auth()->id())->where('product_id', $product_id)->increment('amount', $request->qtybutton);
                }
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
        }
        return back();
    }

    public function cart()
    {
        if (isset($_GET['coupon_name'])) {
            if ($_GET['coupon_name']) {
                $coupon_name = $_GET['coupon_name'];
                if (Coupon::where('coupon_name', $coupon_name)->exists()) {
                    $coupon_info = Coupon::where('coupon_name', $coupon_name)->first();
                    if ($coupon_info->limit != 0) {
                        if ($coupon_info->validity < Carbon::today()->format('Y-m-d')) {
                            $discount_total = 0;
                            return redirect('cart')->with('coupon_err', $coupon_name . ' date is over');
                        }
                        else {
                            $discount_total = (session('s_cart_total') * $coupon_info->discount_percentage)/100;
                            $coupon_name = $_GET['coupon_name'];

                        }
                    }
                    else {
                        $discount_total = 0;
                        return redirect('cart')->with('coupon_err', $coupon_name . ' limit is over');
                    }
                }
                else{
                    $discount_total = 0;
                    return redirect('cart')->with('coupon_err', $coupon_name . ' is invalid');
                }
            }
            else {
                $discount_total = 0;
                $coupon_name = "";
            }
        }
        else {
            $discount_total = 0;
            $coupon_name = "";
        }
        return view('frontend.cart', compact('discount_total', 'coupon_name'));
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

    public function cartupdate(Request $request)
    {
        foreach($request->qtybutton as $cart_id => $updated_amount){
            if (Product::find(Cart::find($cart_id)->product_id)->product_quantity < $updated_amount) {
                return back()->with([
                    'stockout' => 'Only ' . Product::find(Cart::find($cart_id)->product_id)->product_quantity . ' items in stock',
                    'cart_id' => $cart_id
                ]);
            }
            else {
                Cart::find($cart_id)->update([
                    'amount' => $updated_amount
                ]);
            }
        }
        return back();
    }
}
