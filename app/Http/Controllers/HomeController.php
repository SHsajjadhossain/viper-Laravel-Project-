<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\EmailOffer;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        if (strpos(url()->previous(), "product/details")) {
            return redirect(url()->previous());
        }
        return view('home',[
            'total_users' => User::count(),
            'total_admin' => User::where('role', 2)->count(),
            'total_customer' => User::where('role', 1)->count(),
        ]);
    }

    public function emailoffer()
    {
        return view('emailoffer',[
            'customers' => User::where('role','!=', 2)->get()
        ]);
    }

    public function singleemailoffer($id)
    {
        Mail::to(User::find($id)->email)->send(new EmailOffer());
        return back();
    }

    public function checkemailoffer(Request $request)
    {
        foreach ($request->check as $id) {
            Mail::to(User::find($id)->email)->send(new EmailOffer());
        }
        return back();
    }

}
