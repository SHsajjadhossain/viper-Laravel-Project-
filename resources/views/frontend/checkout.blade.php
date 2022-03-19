@extends('layouts.app_frontend')
@section('content')
<style>
    .checkout_error{
        border: 1px solid #dc3545 !important;
    }
</style>
<!-- breadcrumb-area start -->
<div class="breadcrumb-area">
    <div class="container">
        <div class="row align-items-center justify-content-center">
            <div class="col-12 text-center">
                <h2 class="breadcrumb-title">Shop</h2>
                <!-- breadcrumb-list start -->
                <ul class="breadcrumb-list">
                    <li class="breadcrumb-item"><a href="{{ route('frontend') }}">Home</a></li>
                    <li class="breadcrumb-item active">Checkout</li>
                </ul>
                <!-- breadcrumb-list end -->
            </div>
        </div>
    </div>
</div>

<!-- breadcrumb-area end -->


<!-- checkout area start -->
<div class="checkout-area pt-100px pb-100px">
    <div class="container">
        <form action="{{ route('checkout_post') }}" method="POST">
            @csrf
            <div class="row">
                <div class="col-lg-7">
                    <div class="billing-info-wrap">
                        <h3>Billing Details</h3>
                        @if ($errors->any())
                        <div class="alert alert-danger">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </div>
                        @endif
                        <div class="row">
                            <div class="col-lg-6 col-md-6">
                                <div class="billing-info mb-4">
                                    <label>Full Name</label>
                                    <input type="text" value="{{ auth()->user()->name }}" name="name">
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-6">
                                <div class="billing-info mb-4">
                                    <label>Email</label>
                                    <input type="email" value="{{ auth()->user()->email }}" name="email">
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="billing-info mb-4">
                                    <label>Phone Number</label>
                                    <input type="number" @error('phone_number') class="checkout_error" @enderror  name="phone_number" >
                                    @error('phone_number')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="billing-select mb-4">
                                    <label>Country</label>
                                    <select name="country" id="country_dropdown">
                                        <option value="">-Select a country-</option>
                                        @foreach ($countries as $country)
                                        <option value="{{ $country->id }}">{{$country->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="billing-select mb-4">
                                    <label>City</label>
                                    <select name="city" id="city_dropdown" disabled>
                                        <option value="">-Please select country first-</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="billing-info mb-4">
                                    <label>Street Address</label>
                                    <input class="billing-address" placeholder="House number and street name"
                                        type="text" name="address">
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="billing-info mb-4">
                                    <label>Postcode / ZIP</label>
                                    <input type="text" name="postcode">
                                </div>
                            </div>
                        </div>

                        <div class="additional-info-wrap">
                            <h4>Additional information</h4>
                            <div class="additional-info">
                                <label>Order notes</label>
                                <textarea placeholder="Notes about your order, e.g. special notes for delivery. "
                                    name="order_notes"></textarea>
                            </div>
                        </div>

                    </div>
                </div>
                <div class="col-lg-5 mt-md-30px mt-lm-30px ">
                    <div class="your-order-area">
                        <h3>Your order</h3>
                        <div class="your-order-wrap gray-bg-4">
                            <div class="your-order-product-info">
                                <div class="your-order-top">
                                    <ul>
                                        <li>Product</li>
                                        <li>Total</li>
                                    </ul>
                                </div>
                                <div class="your-order-middle">
                                    <ul>
                                        @forelse (allcartts() as $cart)
                                        <li><span class="order-middle-left">{{ $cart->relationtoproduct->product_name }}
                                                X {{ $cart->amount }}</span> <span
                                                class="order-price">${{ $cart->amount * $cart->relationtoproduct->product_price }}
                                            </span></li>
                                        @empty
                                        <tr>
                                            <td class="text-danger text-center" colspan="50">Your cart is empty</td>
                                        </tr>
                                        @endforelse
                                    </ul>
                                </div>
                                <div class="your-order-bottom">
                                    <ul>
                                        <li class="your-order-shipping">Cart Total</li>
                                        <li>${{ Session::get('s_cart_total') }}</li>
                                    </ul>
                                    <ul>
                                        <li class="your-order-shipping">Discount Total ({{Session::get('s_coupon_name')}}) </li>
                                        <li>${{ Session::get('s_discount_total') }}</li>
                                    </ul>
                                    <ul>
                                        <li class="your-order-shipping">Sub Total (approx.)</li>
                                        <li>${{ round(Session::get('s_cart_total')-Session::get('s_discount_total')) }}
                                        </li>
                                    </ul>
                                </div>

                                <div class="your-order-bottom">
                                    <ul>
                                        <li class="your-order-shipping">Shipping</li>
                                        <li>${{ Session::get('s_shipping') }}</li>
                                    </ul>
                                </div>
                                <div class="your-order-total">
                                    <ul>
                                        <li class="order-total">Grand Total</li>
                                        <li>${{ round(Session::get('s_cart_total')-Session::get('s_discount_total'))+Session::get('s_shipping') }}
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <div class="payment-method">
                                <div class="payment-accordion element-mrg">
                                    <div id="faq" class="panel-group">
                                        <ul>
                                            <li class="payment_gateway">Payment Option</li>
                                            <li><input id="payment_1" type="radio" name="payment_option" value="1" /> Cash on delivery (COD) </li>
                                            <li><input id="payment_2" type="radio" name="payment_option" value="2" /> Onlile payment </li>
                                        </ul>
                                        {{-- <div class="panel panel-default single-my-account m-0">
                                            <div class="panel-heading my-account-title">
                                                <h4 class="panel-title"><a data-bs-toggle="collapse"
                                                        href="#my-account-1" class="collapsed"
                                                        aria-expanded="true">Direct bank transfer</a>
                                                </h4>
                                            </div>
                                            <div id="my-account-1" class="panel-collapse collapse show"
                                                data-bs-parent="#faq">

                                                <div class="panel-body">
                                                    <p>Please send a check to Store Name, Store Street, Store Town,
                                                        Store State / County, Store Postcode.</p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="panel panel-default single-my-account m-0">
                                            <div class="panel-heading my-account-title">
                                                <h4 class="panel-title"><a data-bs-toggle="collapse"
                                                        href="#my-account-2" aria-expanded="false"
                                                        class="collapsed">Check payments</a></h4>
                                            </div>
                                            <div id="my-account-2" class="panel-collapse collapse"
                                                data-bs-parent="#faq">

                                                <div class="panel-body">
                                                    <p>Please send a check to Store Name, Store Street, Store Town,
                                                        Store State / County, Store Postcode.</p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="panel panel-default single-my-account m-0">
                                            <div class="panel-heading my-account-title">
                                                <h4 class="panel-title"><a data-bs-toggle="collapse"
                                                        href="#my-account-3">Cash on delivery</a></h4>
                                            </div>
                                            <div id="my-account-3" class="panel-collapse collapse"
                                                data-bs-parent="#faq">

                                                <div class="panel-body">
                                                    <p>Please send a check to Store Name, Store Street, Store Town,
                                                        Store State / County, Store Postcode.</p>
                                                </div>
                                            </div>
                                        </div> --}}
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="Place-order mt-25">
                            <button class="btn-hover" type="submit">Place Order</button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
<!-- checkout area end -->
@endsection

@section('footer_script')
<script>
    $(document).ready(function() {
    $('#country_dropdown').select2();
    $('#country_dropdown').change(function () {
        var country_id = $(this).val();
        $('#city_dropdown').attr('disabled', false);
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $.ajax({
            type : 'POST',
            url : '/get/city/list',
            data : { country_id:country_id },
            success : function (data){
                $('#city_dropdown').html(data);
            }
        });
    });

    $('#city_dropdown').select2();
});
</script>
@endsection
