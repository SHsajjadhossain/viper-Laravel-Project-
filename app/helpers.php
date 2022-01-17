<?php
// wishlists function start
function allwishlists(){
    return App\Models\Wishlist::where('user_id', auth()->id())->get();
}

function wishlistcheck($product_id){
    return App\Models\Wishlist::where('user_id', auth()->id())->where('product_id', $product_id)->exists();
}

function wishlist_id($product_id){
    return App\Models\Wishlist::where('user_id', auth()->id())->where('product_id', $product_id)->first()->id;
}

// wishlists function end

// carts function start
function allcartts()
{
    return App\Models\Cart::where('user_id', auth()->id())->get();
}

function totalcart()
{
    return App\Models\Cart::where('user_id', auth()->id())->count();
}

// carts function end

