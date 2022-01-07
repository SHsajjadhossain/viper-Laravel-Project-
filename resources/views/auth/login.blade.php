@extends('layouts.app_auth')

@section('auth_form')
<div class="card-box p-5">
    <h2 class="text-uppercase text-center pb-4">
        <a href="" class="text-success">
            <span><img src="{{ asset('dashboard')}}/assets/images/logo.png" alt="" height="26"></span>
        </a>
    </h2>

    <form class="" action="{{ route('login') }}" method="POST">
        @csrf
        <div class="form-group m-b-20 row">
            <div class="col-12">
                <label for="emailaddress">Email address</label>
                <input class="form-control" type="email" id="emailaddress" name="email" placeholder="Enter your email">
                @error('email')
                <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
        </div>

        <div class="form-group row m-b-20">
            <div class="col-12">
                <label for="password">Password</label>
                <input class="form-control" type="password" name="password" id="password"
                    placeholder="Enter your password">
                @error('password')
                <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
        </div>

        <div class="form-group row m-b-20">
            <div class="col-12">
                <div class="checkbox checkbox-custom form-check">
                    <input class="form-check-input" name="remember" id="remember" type="checkbox">
                        <label class="form-check-label" for="remember">
                            {{-- Remember me --}}
                            {{ __('Remember Me') }}
                        </label>
                </div>
                {{-- <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="remember" id="remember"
                        {{ old('remember') ? 'checked' : '' }}>

                    <label class="form-check-label" for="remember">
                        {{ __('Remember Me') }}
                    </label>
                </div> --}}

            </div>
        </div>

        <div class="form-group row text-center m-t-10">
            <div class="col-12">
                <button class="btn btn-block btn-custom waves-effect waves-light" type="submit">Log In</button>
            </div>
        </div>

    </form>

    <div class="row m-t-50">
        <div class="col-sm-12 text-center">
            <a href="page-recoverpw.html" class="text-muted"><small>Forgot your password?</small></a>
            <p class="text-muted">Don't have an account? <a href="{{ route('register') }}" class="text-dark m-l-5"><b>Register</b></a></p>
        </div>
    </div>

</div>
@endsection
