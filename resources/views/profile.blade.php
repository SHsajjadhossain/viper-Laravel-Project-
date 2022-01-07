@extends('layouts.app')

@section('breadcrumb')
<div class="page-title-box">
    <h4 class="page-title">Profile </h4>
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
        <li class="breadcrumb-item active">Profile</li>
    </ol>
</div>
@endsection

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-12">
            <div class="alert alert-secondary">
                Account Created : {{ Auth::user()->created_at->diffForHumans() }}
            </div>
        </div>
        <div class="col-lg-6">
            <div class="card">
                <div class="card-header">
                    Change Your Name
                </div>
                <div class="card-body">
                    @if (session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                    @endif

                    <form action="{{ route('profile.namechange') }}" method="POST">
                        @csrf
                        <div class="form-group">
                            <label for="exampleInputEmail1">Name</label>
                            <input type="text" class="form-control" name="name" value="{{ Auth::user()->name }}">
                            @error('name')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <button class="btn btn-success btn-sm">Change Name</button>
                    </form>
                </div>
            </div>
            <div class="card mt-2">
                <div class="card-header">
                    Change Your Photo
                </div>
                <div class="card-body">
                    @if (session('photo_success'))
                    <div class="alert alert-success">
                        {{ session('photo_success') }}
                    </div>
                    @endif
                    <div class="row">
                        <div class="col-12 text-center">
                            <img width="300px" src="{{ asset('uploads/profile_photoes').'/'.Auth::user()->profile_photo }}" alt="Card image cap">
                        </div>
                    </div>
                    <form action="{{ route('profile.photochange') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group">
                            <label for="exampleInputEmail1">New Photo</label>
                            <input type="file" class="form-control" name="new_profile_photo" accept=".jpg, .jpeg, .png, .svg, .bmp, .gif, .webp">
                            @error('new_profile_photo')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <button class="btn btn-success btn-sm">Change Your Photo</button>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-lg-6">
            <div class="card">
                <div class="card-header">
                    Change Your Password
                </div>
                <div class="card-body">
                    @if (session('success_pass'))
                    <div class="alert alert-success">
                        {{ session('success_pass') }}
                    </div>
                    @endif

                    @if ($errors->any())
                    <div class="alert alert-danger">
                        @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                        @endforeach
                    </div>
                    @endif

                    <form action="{{ route('profile.passwordchange') }}" method="POST">
                        @csrf
                        <div class="form-group">
                            <label>Old Password</label>
                            <input type="password" class="form-control" name="old_password">
                        </div>
                        <div class="form-group">
                            <label>New Password</label>
                            <input type="password" class="form-control" name="password"">
                        </div>
                        <div class=" form-group">
                            <label>Confirm Password</label>
                            <input type="password" class="form-control" name="password_confirm">
                        </div>
                        <button class="btn btn-success btn-sm">Change Password</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
