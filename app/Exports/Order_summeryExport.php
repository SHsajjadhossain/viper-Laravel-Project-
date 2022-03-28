<?php

namespace App\Exports;

use App\Models\Order_summery;
use Maatwebsite\Excel\Concerns\FromCollection;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class Order_summeryExport implements FromView
{

    public function view(): View
    {
        return view('excel.invoices', [
            'invoices' => Order_summery::all()
        ]);
    }
}
