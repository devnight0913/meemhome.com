@extends('layouts.app')
@section('title', 'Login | ' . config('app.name'))

@section('content')

    <div class="row justify-content-center align-items-center mt-5">
        <div class="col-xl-5 col-lg-5 col-md-6 col-sm-12 border rounded-4 py-3">
            <div class=" text-uppercase fw-bold h3 mb-3 text-center">  Reset Your Password</div>
            <form action="{{ route('password.reset.submit') }}" method="POST">
                @csrf
                <input name="token" value="{{ $token }}" class="d-none">
                <div class="mb-3">
                    <input type="text" id="email" name="email" placeholder="Email" class="form-control" aria-label="Email"
                        value="{{ $email ?? old('email') }}">
                    @error('email')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>
                <div class="mb-3">
                    <input type="password" id="password" name="password" placeholder="Password" class="form-control"
                        aria-label="password">
                    @error('password')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <input type="password" id="password_confirmation" name="password_confirmation"
                        placeholder="Confirm Password" class="form-control" aria-label="Confirm Password">
                    @error('password_confirmation')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>

                <button type="submit" class="btn btn-primary px-4 text-capitalize w-100 mb-3">
                    Reset Password
                </button>
            </form>

        </div>
    </div>


@endsection
