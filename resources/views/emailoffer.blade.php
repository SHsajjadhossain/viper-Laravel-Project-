@extends('layouts.app')

@section('breadcrumb')
<div class="page-title-box">
    <h4 class="page-title">Home </h4>
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
        <li class="breadcrumb-item"><a href="#">Email-Offer</a></li>
    </ol>
</div>
@endsection

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">Dashboard</div>

                <div class="card-body">
                    @if (auth()->user()->role == 2)
                        <table class="table table-bordered table-sm">
                        <tr>
                            <th>Check</th>
                            <th>SL.No</th>
                            <th>Customaer Name</th>
                            <th>Customer  Email</th>
                            <th>Action</th>
                        </tr>
                        <form action="{{ route('checkemailoffer') }}" method="POST">
                            @csrf
                            @foreach ($customers as $customer)
                                <tr>
                                    <td>
                                        <input type="checkbox" name="check[]" class="form-control" value="{{ $customer->id }}">
                                    </td>
                                    <td>{{ $loop->index + 1 }}</td>
                                    <td>{{ $customer->name }}</td>
                                    <td>{{ $customer->email }}</td>
                                    <td>
                                    <a href="{{ route('singeemailoffer', $customer->id) }}" class="btn btn-sm btn-success">Send</a>
                                    </td>
                                </tr>
                            @endforeach
                        <tr>
                            <td class="text-center">
                                <button class="btn btn-sm btn-info">Send Check</button>
                            </td>
                        </tr>
                        </form>
                    </table>
                    @else
                        <div class="alert alert-danger">
                            You are not allowed to view on this page
                        </div>
                    @endif

                </div>
            </div>
        </div>
    </div>
</div>
@endsection

