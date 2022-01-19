<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use App\Models\Product_thumbnail;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Image;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // return Product::all()->id()->get();
        return view('product.index', [
            'products' => Product::where('user_id', auth()->id())->get(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('product.create', [
            'active_categories' => Category::where('status', 'show')->get()
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $slug = Str::slug($request->product_name).'-'.Str::random(5).auth()->id();
        $request->validate([
            'category_id' => 'required'
        ]);
        // photo upload start
            $new_product_photo_name = time().'_'.Str::random(5).'_'.Auth::id().'.'.$request->file('product_photo')->getClientOriginalExtension();
            Image::make($request->file('product_photo'))->resize(270, 310)->save(base_path('public/uploads/product_photoes/'.$new_product_photo_name));
        // photo upload end
        $product_id = Product::insertGetId([
            'user_id' => auth()->id(),
            'category_id' => $request->category_id,
            'product_name' => $request->product_name,
            'product_price' => $request->product_price,
            'product_code' => $request->product_code,
            'product_short_description' => $request->product_short_description,
            'product_long_description' => $request->product_long_description,
            'product_photo' => $new_product_photo_name,
            'product_slug' => $slug,
            'product_quantity' => $request->product_quantity
        ]);

        foreach ($request->file('product_thumbnails') as  $product_thumbnail) {
            // photo upload start
            $new_product_photo_name = time() . '_' . Str::random(5) . '_' . $product_id . '.' . $product_thumbnail->getClientOriginalExtension();
            Image::make($product_thumbnail)->resize(800, 800)->save(base_path('public/uploads/product_thumbnails/' . $new_product_photo_name));
            // photo upload end
            Product_thumbnail::insert([
                'product_id' => $product_id,
                'product_thumbnail_name' => $new_product_photo_name,
                'created_at' => Carbon::now()
            ]);
        }
        return back();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function edit(Product $product)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Product $product)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {
        //
    }
}
