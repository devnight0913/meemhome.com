@extends('layouts.app')
@section('title', 'Change Password')
@section('content')

    <section>
        <div class="h4">Update Password</div>
        <div class="mb-3 text-muted">Make Sure You Have Long And Random Password</div>
        <form action="{{ route('user.password.update') }}" method="POST">
            @csrf
            @method('PUT')
            <div class="mb-3">
                <label for="current_password" class="form-label fw-bold">Current Password</label>
                <input type="password" id="current_password" name="current_password" class="form-control">
                @error('current_password')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="new_password" class="form-label fw-bold">New Password</label>
                <input type="password" id="new_password" name="new_password" class="form-control">
                @error('new_password')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="new_password_confirmation" class="form-label fw-bold">Confirm New Password</label>
                <input type="password" id="new_password_confirmation" name="new_password_confirmation" class="form-control">
                @error('new_password_confirmation')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            <button type="submit" class="btn btn-primary px-4 text-capitalize float-end mb-3">
                Update Password
            </button>
        </form>
    </section>
@endsection
