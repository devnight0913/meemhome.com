@extends('layouts.app')
@section('title', 'Login | ' . config('app.name'))

@section('content')

    <div class="row justify-content-center align-items-center py-3">
        <div class="col-xl-5 col-lg-5 col-md-6 col-sm-12 border rounded-4 py-3">
            <div class=" text-uppercase fw-bold h3 mb-3 text-center">
                <img src="{{ asset('images/webp/meemhome-original.webp') }}" alt="{{ config('app.name') }}" class="w-100 py-3 px-5">
                {{ $title ?? 'Login' }}
            </div>

            <form action="{{ route('login.attempt', ['next' => $next ?? null]) }}" role="form" method="POST">
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
                    <a href="{{ route('forgot-password') }}" class="link-primary">
                        Forgot Password?
                    </a>
                </div>

                <button type="submit" class="btn btn-primary w-100 btn-lg mb-3">Login</button>
            </form>
            <hr>
            <div class="mb-3 text-center">
                <a href="{{ route('sign-up') }}" class="link-primary">
                    Don't Have An Account? Register Here
                </a>
            </div>
        </div>
    </div>


@endsection
