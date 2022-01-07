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
                <div class="card-header">Add Vendor</div>
                <div class="card-body">
                    @if ($errors->any())
                    <div class="alert alert-danger">
                        @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                        @endforeach
                    </div>
                    @endif
                    <form action="{{ route('vendor.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group">
                            <label>Vendor Name</label>
                            <input type="text" class="form-control" name="vendor_name"
                                placeholder="Enter Vendor Name">
                        </div>
                        <div class="form-group">
                            <label>Vendor Email</label>
                            <input type="email" class="form-control" name="vendor_email"
                                placeholder="Enter Vendor Email">
                        </div>
                        <div class="form-group">
                            <label>Vendor Phone Number</label>
                            <input type="text" class="form-control" name="vendor_phone_number"
                                placeholder="Enter Vendor Phone Number">
                        </div>
                        <div class="form-group">
                            <label>Vendor Address</label>
                            <input type="text" class="form-control" name="vendor_address"
                                placeholder="Enter Vendor Address">
                        </div>
                        <button type="submit" class="btn btn-primary">Add New Vendor</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

