@extends('admin.layouts.app')
@section('title', 'Edit User Deposit')

@section('content')

    <form aaction="{{ route('admin.users.deposit.update', $user) }}" method="POST" enctype="multipart/form-data"
        role="form">
        @csrf
        @method('PUT')

        <div class="d-flex align-items-center mb-3">
            <div class="flex-grow-1 h5 fw-bold m-0">
                <div class="d-flex align-items-center">
                    <div class="me-2">
                        <img src="{{ $user->profile_photo_url_small }}" alt="{{ $user->name }}"
                            class="profile-photo rounded-circle me-1 border" height="45">
                    </div>
                    <div>
                        <div class="fw-bold h5 mb-0">{{ $user->name }}</div>
                        <div class="text-muted small">
                            ID: <span class="fw-bold">{{ $user->id }}</span>
                        </div>
                        <div>
                            Current Deposit: <span class="fw-bold">{{ usd_money_format($user->deposit) }}</span>
                        </div>
                    </div>
                </div>
            </div>
            <button class="btn btn-primary px-md-4 ms-auto" type="submit">Save</button>
        </div>

        @include('admin.users.partials.deposit')

    </form>
@endsection
