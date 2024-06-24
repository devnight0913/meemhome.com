@extends('admin.layouts.app')
@section('title', 'User Manager')
@section('page_name', 'User Manager')
@push('head')
    <style>
        td {
            vertical-align: middle;
        }
    </style>
@endpush
@section('content')
    <div class="d-flex align-items-center mb-3">
        <div class="flex-grow-1">
            <span class="h5 fw-bold m-0 ff-montserrat">Users</span> <span>({{ $users->total() }})</span>
        </div>
        <a class="btn btn-primary px-md-4 ms-auto" href="{{ route('admin.users.create') }}">Create New User</a>
    </div>
    <div class="border rounded-4 p-3 mb-3 bg-white border-light shadow-sm">

        <div class="d-flex align-items-center mb-3">
            <div class="flex-grow-1  m-0">
                <form action="" role="form" method="GET">
                    <div class="position-relative mb-3">
                        <input type="search" class="form-control w-auto" name="search_query" id="search"
                            autocomplete="off" placeholder="Search..." style="padding-left: 2.5rem !important"
                            value="{{ Request::get('search_query') }}" />
                        <div class="position-absolute top-50 start-0 translate-middle-y p-2">
                            <search-icon-component></search-icon-component>
                        </div>
                    </div>
                </form>
            </div>
            <div>
                @include('admin.users.sort')
            </div>
        </div>

        <div class="table-responsive">
            <table class="table table-striped table-bordered table-hover mb-0">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Phone</th>
                        <th>Role</th>
                        <th>Joined</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($users as $user)
                        <tr>
                            <td>
                                <div class="d-flex align-items-center">
                                    <div class="me-2">
                                        <img src="{{ $user->profile_photo_url_small }}" alt="{{ $user->name }}"
                                            class="profile-photo rounded-circle me-1 border" height="45">
                                    </div>
                                    <div>
                                        <div class="fw-bold h5 mb-0">{{ $user->name }}</div>

                                        <div class="@if ($user->is_super_admin && !auth()->user()->is_super_admin) d-none @endif">
                                            <div class="text-muted small">
                                                ID: <span class="fw-bold">{{ $user->id }}</span>
                                            </div>
                                            {{-- <div>
                                                Deposit: <span class="fw-bold">{{ usd_money_format($user->deposit) }}</span>
                                            </div> --}}
                                        </div>
                                    </div>
                                </div>
                            </td>
                            <td><a class="link-primary" href="mailto:{{ $user->email }}">{{ $user->email }}</a>
                            <td><a class="link-primary" href="tel:{{ $user->full_phone }}">{{ $user->full_phone }}</a>
                            </td>
                            <td>
                                <div class="d-flex align-items-center">
                                    <div class="me-2">{{ $user->role }}</div>
                                    @if ($user->is_admin)
                                        <div>
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                                stroke-width="1.5" stroke="currentColor" class="hero-icon">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="M9 12.75L11.25 15 15 9.75m-3-7.036A11.959 11.959 0 013.598 6 11.99 11.99 0 003 9.749c0 5.592 3.824 10.29 9 11.623 5.176-1.332 9-6.03 9-11.622 0-1.31-.21-2.571-.598-3.751h-.152c-3.196 0-6.1-1.248-8.25-3.285z" />
                                            </svg>
                                        </div>
                                    @endif
                                </div>
                            </td>
                            <td>
                                {{ $user->joined_at }}
                            </td>

                            <td>

                                <button type="button" class="btn btn-link text-dark user-select-none"
                                    data-bs-toggle="modal" data-bs-target="#Modal{{ $user->id }}">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                        stroke-width="1.5" stroke="currentColor" class="hero-icon">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M6.75 12a.75.75 0 11-1.5 0 .75.75 0 011.5 0zM12.75 12a.75.75 0 11-1.5 0 .75.75 0 011.5 0zM18.75 12a.75.75 0 11-1.5 0 .75.75 0 011.5 0z" />
                                    </svg>
                                </button>
                                <!-- Modal -->
                                <div class="modal" id="Modal{{ $user->id }}" tabindex="-1"
                                    aria-labelledby="Modal{{ $user->id }}Label" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered">
                                        <div class="modal-content">
                                            <div class="modal-body p-0">
                                                <div class="p-3  text-center">
                                                    <img src="{{ $user->profile_photo_url_small }}"
                                                        alt="{{ $user->name }}"
                                                        class="profile-photo rounded-circle border mb-3" height="75">
                                                    <div>
                                                        <div class="fw-bold">{{ $user->name }}</div>
                                                        <div
                                                            class="text-muted small @if ($user->is_super_admin && !auth()->user()->is_super_admin) d-none @endif">
                                                            ID: <span class="fw-bold">{{ $user->id }}</span>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="@if ($user->is_super_admin && !auth()->user()->is_super_admin) d-none @endif">

                                                    <a href="{{ route('admin.users.show', $user) }}"
                                                        class="btn btn-link w-100 py-3 border-top text-dark text-decoration-none">
                                                        View
                                                    </a>
                                                    <a href="{{ route('admin.users.edit', $user) }}"
                                                        class="btn btn-link w-100 py-3 border-top text-dark text-decoration-none">
                                                        Edit
                                                    </a>
                                                    {{-- <a href="{{ route('admin.users.deposit.edit', $user) }}"
                                                        class="btn btn-link w-100 py-3 border-top text-dark text-decoration-none">
                                                        Edit Deposit ({{ usd_money_format($user->deposit) }})
                                                    </a> --}}
                                                    <form action="{{ route('admin.users.destroy', $user) }}" method="POST"
                                                        onSubmit="return confirm('Are you sure?');" class="">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit"
                                                            class="btn btn-link w-100 py-3 border-top text-danger text-decoration-none">Delete</button>
                                                    </form>
                                                </div>



                                                <button type="button"
                                                    class="btn btn-link w-100 py-3 border-top text-dark text-decoration-none"
                                                    data-bs-dismiss="modal">Close</button>

                                            </div>
                                        </div>
                                    </div>
                                </div>


                                {{-- 
                                    <form action="{{ route('admin.users.destroy', $user) }}" method="POST"
                                        onSubmit="return confirm('Are you sure?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-xs">Delete</button>
                                    </form> --}}
                            </td>

                        </tr>
                    @endforeach
                </tbody>
            </table>
            {{ $users->withQueryString()->links() }}
            @if ($users->isEmpty())
                <no-content-component></no-content-component>
            @endif
        </div>


    </div>

@endsection
