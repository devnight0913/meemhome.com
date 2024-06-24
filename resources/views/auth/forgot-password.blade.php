@extends('layouts.app')
@section('title', 'Login | ' . config('app.name'))

@section('content')

    <div class="row justify-content-center align-items-center mt-5">
        <div class="col-xl-5 col-lg-5 col-md-6 col-sm-12 border rounded-4 py-3">
            <div class=" text-uppercase fw-bold h3 mb-3 text-center">FORGOT PASSWORD</div>
            <form action="{{ route('forgot-password.send') }}" role="form" method="POST">
                @csrf
                <div class="form-floating mb-3">
                    <input type="email" class="form-control @error('email') is-invalid @enderror" name="email"
                        id="email" placeholder="Email" value="{{ old('email') }}">
                    <label for="email">Email address</label>
                    @error('email')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                <button class="btn btn-primary w-100 btn-lg mb-3" type="submit">Send reset link</button>
            </form>
            <hr>
            <div class="mb-3 text-center">
                <a href="{{ route('login') }}" class="link-primary">
                    Back to login
                </a>
            </div>
        </div>
    </div>


@endsection
