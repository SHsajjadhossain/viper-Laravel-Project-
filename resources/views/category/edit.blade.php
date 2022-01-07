@extends('layouts.app')

@section('breadcrumb')
<div class="page-title-box">
    <h4 class="page-title">Home </h4>
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
        <li class="breadcrumb-item"><a href="{{ route('category.index') }}">List Category</a></li>
        <li class="breadcrumb-item"><a href="#">Edit Category</a></li>
    </ol>
</div>
@endsection

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">Edit Category - {{ $category->category_name }}</div>
                <div class="card-body">
                    {{-- @if ($errors->any())
                    <div class="alert alert-danger">
                        @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                        @endforeach
                    </div>
                    @endif --}}
                    <form action="{{ route('category.update', $category->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PATCH')
                        <div class="form-group">
                            <label>Category Status</label>
                            <select name="status" class="form-control">
                                <option value="show"{{ ($category->status == 'show')?'selected' : '' }}>Show</option>
                                <option value="hide"{{ ($category->status == 'hide')?'selected' : '' }}>Hide</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Category Name</label>
                            <input type="text" class="form-control" name="category_name" value="{{ $category->category_name }}"
                                placeholder="Enter Category Name">
                        </div>
                        <div class="form-group">
                            <label>Category Tagline</label>
                            <input type="text" class="form-control" name="category_tagline" value="{{ $category->category_tagline}}"
                                placeholder="Enter Category Tagline">
                        </div>
                        <div class="form-group">
                            <label>Old Category Photo</label>
                            <br>
                            <img width="150" src="{{ asset('uploads/category_photoes').'/'.$category->category_photo }}" alt="">
                        </div>
                        <div class="form-group">
                            <label>New Category Photo</label>
                            <input type="file" class="form-control" name="new_category_photo">
                        </div>
                        <button type="submit" class="btn btn-primary">Edit Category</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

