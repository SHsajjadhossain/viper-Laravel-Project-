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
                <div class="card-header">Add Category</div>
                <div class="card-body">
                    @if ($errors->any())
                    <div class="alert alert-danger">
                        @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                        @endforeach
                    </div>
                    @endif
                    <form action="{{ route('category.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group">
                            <label>Category Name</label>
                            <input type="text" class="form-control" name="category_name"
                                placeholder="Enter Category Name">
                        </div>
                        <div class="form-group">
                            <label>Category Tagline</label>
                            <input type="text" class="form-control" name="category_tagline"
                                placeholder="Enter Category Tagline">
                        </div>
                        <div class="form-group">
                            <label>Category Photo</label>
                            <input type="file" class="form-control" name="category_photo">
                        </div>
                        <button type="submit" class="btn btn-primary">Add New Category</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
