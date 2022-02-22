@extends('layouts.app')

@section('breadcrumb')
<div class="page-title-box">
    <h4 class="page-title">Home </h4>
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
        <li class="breadcrumb-item"><a href="#">Vendor</a></li>
        <li class="breadcrumb-item"><a href="#">Add Vendor</a></li>
    </ol>
</div>
@endsection

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">Add Coupon</div>
                <div class="card-body">
                    @if ($errors->any())
                    <div class="alert alert-danger">
                        @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                        @endforeach
                    </div>
                    @endif
                    <form action="{{ route('coupon.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group">
                            <label>Coupon Name</label>
                            <input type="text" class="form-control" name="coupon_name"
                                placeholder="Enter Coupon Name">
                        </div>
                        <div class="form-group">
                            <label>Coupon Discount Percentage</label>
                            <input type="text" class="form-control" name="discount_percentage"
                                placeholder="Enter Discount Percentage">
                        </div>
                        <div class="form-group">
                            <label>Coupon Validity</label>
                            <input type="date" class="form-control" name="validity">
                        </div>
                        <div class="form-group">
                            <label>Coupon Limit</label>
                            <input type="text" class="form-control" name="limit"
                                placeholder="Enter Coupon Limit">
                        </div>
                        <button type="submit" class="btn btn-primary">Add New Coupon</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

