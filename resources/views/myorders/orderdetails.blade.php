@extends('layouts.app')

@section('breadcrumb')
<div class="page-title-box">
    <h4 class="page-title">Home </h4>
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
        <li class="breadcrumb-item"><a href="{{ route('my.orders') }}">List Orders</a></li>
        <li class="breadcrumb-item">Order Details</li>
    </ol>
</div>
@endsection

@section('content')

<style>
    .rate {
    float: left;
    height: 46px;
    padding: 0;
    margin-top: 5px;
}
.rate:not(:checked) > input {
    position:absolute;
    top: 0;
    opacity: 0;
}
.rate:not(:checked) > label {
    float:right;
    width:1em;
    overflow:hidden;
    white-space:nowrap;
    cursor:pointer;
    font-size:30px;
    color:#ccc;
}
.rate:not(:checked) > label:before {
    content: '★ ';
}
.rate > input:checked ~ label {
    color: #ffc700;
}
.rate:not(:checked) > label:hover,
.rate:not(:checked) > label:hover ~ label {
    color: #deb217;
}
.rate > input:checked + label:hover,
.rate > input:checked + label:hover ~ label,
.rate > input:checked ~ label:hover,
.rate > input:checked ~ label:hover ~ label,
.rate > label:hover ~ input:checked ~ label {
    color: #c59b08;
}

.review span{
    display: block;
    font-size: 14px;
    color: #313a46;
    font-family: "Rubik", sans-serif;
    font-weight: 500;
}

.review .btn{
    margin-top: 10px;
    margin-left: 5px;
}

</style>

<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">My Order Details</div>
                <div class="card-body">
                    <table class="table table-bordered table-inverse">
                        <tbody>
                            <tr>
                                <td>User Name</td>
                                <td>{{ $order_summeries->relationwithuser->name }}</td>
                            </tr>

                            <tr>
                                <td>Coupon Name</td>
                                <td>{{ ($order_summeries->coupon_name)? $order_summeries->coupon_name:'N/A' }}</td>
                            </tr>
                            <tr>
                                <td> Cart Total</td>
                                <td>{{ $order_summeries->cart_total }}</td>
                            </tr>
                            <tr>
                                <td>Discount Total</td>
                                <td>{{ $order_summeries->discount_total }}</td>
                            </tr>
                            <tr>
                                <td>Sub Total</td>
                                <td>{{ $order_summeries->sub_total }}</td>
                            </tr>
                            <tr>
                                <td>Grand Total</td>
                                <td>{{ $order_summeries->grand_total }}</td>
                            </tr>
                            <tr>
                                <td>Payment Option</td>
                                <td>
                                    @if ($order_summeries->payment_option == 1)
                                        Cash on delivery
                                    @else
                                        <span>Online Payment</span>
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <td>Payment Status</td>
                                <td>
                                    @if ($order_summeries->payment_status == 0)
                                        <span class="badge badge-danger">Not Paid Yet</span>
                                    @else
                                        <span class="badge badge-success"> Paid </span>
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <td>Created at</td>
                                <td>{{ $order_summeries->created_at }}</td>
                            </tr>
                            <tr>
                                <td>Delivery Status</td>
                                <td>
                                    @if ($order_summeries->deliver_status == 0)
                                        <span class="badge badge-warning">Pending</span>
                                    @else
                                        <span class="badge badge-primary"> Delivered </span>
                                    @endif
                                </td>
                            </tr>
                            </tbody>
                    </table>
                </div>
                <div class="card-footer">
                    @foreach ($order_details as $order_detail)
                    <div class="card">
                        <div class="card-body">
                            <table class="table table-bordered table-inverse">
                                <tbody>
                                    <tr>
                                        <td>Product Name</td>
                                        <td>{{ $order_detail->relationwithproduct->product_name }}</td>
                                    </tr>
                                    <tr>
                                        <td>Product Photo</td>
                                        <td>
                                            <img  style="width: 200px; height:200px;" src="{{ asset('uploads/product_photoes') }}/{{ $order_detail->relationwithproduct->product_photo }}" alt="Not found">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Vendor Name</td>
                                        <td>{{ $order_detail->relationwithuser->name }}</td>
                                    </tr>
                                    <tr>
                                        <td>Amount</td>
                                        <td>{{ $order_detail->amount }}</td>
                                    </tr>
                                </tbody>
                            </table>
                            <div class="row">
                                <div class="col-12 review">
                                    @if ($order_summeries->deliver_status == 1)
                                        <form action="{{ route('rating', $order_detail->id) }}" method="POST">
                                            @csrf
                                            <div class="form-group">
                                                <label for="">Your Review</label>
                                                <textarea class="form-control" name="review" id="" rows="4"></textarea>
                                            </div>
                                               <span>Your Rating</span>
                                                <div class="rate">
                                                    <input type="radio" id="star5" name="rate" value="5" />
                                                    <label for="star5" title="text">5 stars</label>
                                                    <input type="radio" id="star4" name="rate" value="4" />
                                                    <label for="star4" title="text">4 stars</label>
                                                    <input type="radio" id="star3" name="rate" value="3" />
                                                    <label for="star3" title="text">3 stars</label>
                                                    <input type="radio" id="star2" name="rate" value="2" />
                                                    <label for="star2" title="text">2 stars</label>
                                                    <input type="radio" id="star1" name="rate" value="1" />
                                                    <label for="star1" title="text">1 star</label>
                                                </div>
                                            <div class="form-gorup">
                                                <button class="btn btn-success" type="submit">Submit</button>
                                            </div>
                                        </form>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('footer_script')

@endsection
