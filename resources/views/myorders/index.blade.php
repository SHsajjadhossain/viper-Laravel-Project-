@extends('layouts.app')

@section('breadcrumb')
<div class="page-title-box">
    <h4 class="page-title">Home </h4>
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
        <li class="breadcrumb-item">List Orders</li>
    </ol>
</div>
@endsection

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">My Orders</div>
                <div class="card-body">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Order ID</th>
                                <th>Grand Total</th>
                                <th>Payment Option</th>
                                <th>Payment Status</th>
                                <th>QR Code</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($order_summeries as $order_summery)
                                <tr>
                                    <td>{{ $order_summery->id }}</td>
                                    <td>{{ $order_summery->grand_total }}</td>
                                    <td>
                                        @if ($order_summery->payment_option == 1)
                                            Cash on delivery
                                        @else
                                            <span>Online Payment</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if ($order_summery->payment_status == 0)
                                            <span class="badge badge-danger">Not Paid Yet</span>
                                        @else
                                            <span class="badge badge-success"> Paid </span>
                                        @endif
                                    </td>
                                    <td>
                                        {!! DNS2D::getBarcodeHTML('4445645656', 'QRCODE', 3,3) !!}
                                    </td>
                                    <td>
                                        <a class="btn btn sm btn-success" href="{{ route('order.details', Crypt::encryptString($order_summery->id) ) }}">Details</a>
                                        <a class="btn btn sm btn-info" href="{{ route('invoice.download') }}">Invoice Download PDF</a>
                                        <a class="btn btn sm btn-warning" href="{{ route('invoice.download.excel') }}">Invoice Download Excel</a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('footer_script')

@endsection



