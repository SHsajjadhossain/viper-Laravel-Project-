<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\EmailOffer;
use App\Models\Country;
use App\Models\Order_summery;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Exports\Order_summeryExport;
use App\Models\Order_detail;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Crypt;

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

    public function location ()
    {
        return view('location.index', [
            'countries' => Country::get(['id', 'name', 'status'])
        ]);
    }

    public function location_update (Request $request)
    {
        Country::where('status', 'active')->update([
            'status' => 'deactive'
        ]);

        foreach ($request->countries as $country_id) {
            Country::find($country_id)->update([
                'status' => 'active'
            ]);
        }
        return back();
    }

    public function myorders  ()
    {
        return view('myorders.index', [
            'order_summeries' => Order_summery::where('user_id', auth()->id())->get()
        ]);
    }

    public function invoicedownload   ()
    {
        $pdf = PDF::loadView('pdf.invoice');
        return $pdf->stream('invoice.pdf');
    }

    public function invoicedownloadexcel ()
    {
        return Excel::download(new Order_summeryExport, 'Order_summery.xlsx');
    }

    public function orderdetails ($id)
    {
        $order_summeries = Order_summery::find(Crypt::decryptString($id));
        $order_details = Order_detail::where('order_summery_id', Crypt::decryptString($id))->get();
        return view('myorders.orderdetails', compact('order_summeries', 'order_details'));
    }
    public function allorders ()
    {
        return view('allorders.index', [
            'order_summeries' => Order_summery::all()
        ]);
    }

    public function markasrecieved ($id)
    {
        Order_summery::find($id)->update([
            'deliver_status' => 1
        ]);
        return back();
    }
    public function rating (Request $request, $id)
    {
        return $id;
        return $request->except('_token');
    }

}
