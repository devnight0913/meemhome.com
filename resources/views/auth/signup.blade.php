@extends('layouts.app')
@section('title', 'Sign Up | ' . config('app.name'))

@section('content')

    <div class="row justify-content-center align-items-center mt-5">
        <div class="col-xl-5 col-lg-5 col-md-6 col-sm-12 border rounded-4 py-3">
            <div class=" text-uppercase fw-bold h3 mb-3 text-center">CREATE ACCOUNT</div>
            <form action="{{ route('sign-up.submit') }}" role="form" method="POST">
                @csrf
                <div class="form-floating mb-3">
                    <input type="text" class="form-control @error('name') is-invalid @enderror" name="name"
                        id="name" placeholder="Your Name" value="{{ old('name') }}">
                    <label for="name">Your Name</label>
                    @error('name')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
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
                <div class="form-floating mb-3">
                    <input type="password" class="form-control @error('password') is-invalid @enderror" name="password"
                        id="password" placeholder="Password" autocomplete="on">
                    <label for="password">Password</label>
                    @error('password')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                <div class="mb-3">
                    By Clicking "Create Account" you agree to our <a href="{{ route('terms.show') }}"
                        class="link-primary">Terms of Service</a> and acknowledge that our <a
                        href="{{ route('privacy.show') }}" class="link-primary">Privacy Policy</a>
                    applies to you.
                </div>
                <button class="btn btn-primary w-100 btn-lg mb-3" type="submit">CREATE ACCOUNT</button>
            </form>
            @include('layouts.re-captcha', ['textColor' => 'text-dark'])

            <hr>
            <div class="mb-3 text-center">
                <a href="{{ route('login') }}" class="link-primary">
                    Already Have An Account? Log In
                </a>
            </div>
        </div>
    </div>


@endsection
