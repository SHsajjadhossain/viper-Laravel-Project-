@extends('layouts.app')

@section('breadcrumb')
<div class="page-title-box">
    <h4 class="page-title">Home </h4>
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
        <li class="breadcrumb-item"><a href="#">Product</a></li>
        <li class="breadcrumb-item"><a href="#">List Product</a></li>
    </ol>
</div>
@endsection

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">List Product</div>
                <div class="card-body">
                    <table class="table table-bordered">
                        <thead class="thead-inverse">
                            <tr>
                                <th>Product Name</th>
                                <th>Product Price</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($products as $product)
                            <tr>
                                <td>{{ $product->product_name }}</td>
                                <td>${{ $product->product_price }}</td>
                                {{-- <td>
                                    <img width="150" src="{{ asset('uploads/category_photoes').'/'.$category->category_photo }}" alt="">
                                </td>
                                <td>{{ $category->status }}</td>
                                <td>
                                    <a href="{{ route('category.edit', $category->id) }}" class="btn btn-sm btn-info">Edit</a>
                                    <form style="display: inline-block;"  action="{{ route('category.destroy', $category->id) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-sm btn-danger ml-1">Delete</button>
                                    </form>
                                </td>
                            </tr> --}}
                            @empty
                            <tr class="text-center text-danger">
                                <td colspan="50">No Record To Show</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    @endsection

