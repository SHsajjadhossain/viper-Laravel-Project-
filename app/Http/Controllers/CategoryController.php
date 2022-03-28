<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Intervention\Image\ImageManagerStatic as Image;
use Illuminate\Support\Str;
use App\Models\Category;
use Carbon\Carbon;

class CategoryController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('category.index', [
            'categories' => Category::all()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('category.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'category_name' => 'required',
            'category_tagline' => 'required',
            'category_photo' => 'required|image|mimes:jpg,bmp,png'
        ]);
        // photo upload start
        $new_category_photo_name = time().'_'.Str::random(10).'_'.Auth::id().'.'.$request->file('category_photo')->getClientOriginalExtension();
        Image::make($request->file('category_photo'))->resize(600, 328)->save(base_path('public/uploads/category_photoes/'.$new_category_photo_name));
        // photo upload end

        // db insert start
        Category::insert([
            'category_name' => $request->category_name,
            'category_tagline' => $request->category_tagline,
            'category_photo' => $new_category_photo_name,
            'created_at' => Carbon::now()
        ]);
        // db insert end
        return back();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $category = Category::find($id);
        return view('category.edit', compact('category'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        if ($request->hasFile('new_category_photo')) {
            $new_category_photo_name = time().'_'.Str::random(10).'_'.Auth::id().'.'.$request->file('new_category_photo')->getClientOriginalExtension();
            // delete old photo
            unlink(base_path('public/uploads/category_photoes/'.Category::find($id)->category_photo));

            // upload new photo
            Image::make($request->file('new_category_photo'))->resize(600, 328)->save(base_path('public/uploads/category_photoes/'.$new_category_photo_name));
            // update to database
            Category::find($id)->update([
                'category_photo' => $new_category_photo_name
            ]);
        }


        Category::find($id)->update([
            'category_name'=> $request->category_name,
            'category_tagline' => $request->category_tagline,
            'status' => $request->status
        ]);
        return back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $category = Category::find($id);
        unlink(base_path('public/uploads/category_photoes/'.$category->category_photo));
        $category->delete();
        return back();
    }
}
