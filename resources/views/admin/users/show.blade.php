@extends('admin.layouts.app')
@section('title', 'Edit User')

@section('content')
    <div class="border rounded-4 p-3 mb-3 bg-white border-light shadow-sm">

        <div class="mb-3">
            <img src="{{ $user->profile_photo_url_medium }}" class="object-fit-cover rounded-circle cursor-pointer border"
                alt="image" widtd="100" height="100" id="profile-photo">
        </div>
        <div class=" table-responsive">
            <table class="table table-striped table-bordered table-hover mb-0">
                <tr>
                    <td>ID</td>
                    <td>{{ $user->id }}</td>
                </tr>
                <tr>
                    <td>Role</td>
                    <td>{{ $user->role }}</td>
                </tr>
                <tr>
                    <td>Name</td>
                    <td>{{ $user->name }}</td>
                </tr>
                <tr>
                    <td>Birthday</td>
                    <td>{{ $user->birthday_date }}</td>
                </tr>
                <tr>
                    <td>Gender</td>
                    <td>{{ $user->gender }}</td>
                </tr>
                <tr>
                    <td>Email</td>
                    <td>
                        <a href="mailto:{{ $user->email }}" class=" link-primary">{{ $user->email }}</a>
                    </td>
                </tr>
                <tr>
                    <td>Phone</td>
                    <td>
                        <a href="tel:{{ $user->full_phone }}" class=" link-primary">{{ $user->full_phone }}</a>
                    </td>
                </tr>

                <tr>
                    <td>Delivery Address</td>
                    <td>
                        @if ($user->area)
                            {{ $user->area->name }},
                        @endif
                        {{ $user->address }}
                    </td>
                </tr>
                {{-- <tr>
                    <td>Deposit</td>
                    <td>{{ usd_money_format($user->deposit) }}</td>
                </tr> --}}
                <tr>
                    <td>Contact Email</td>
                    <td>
                        <a href="mailto:{{ $user->contact_email }}" class=" link-primary">{{ $user->contact_email }}</a>
                    </td>
                </tr>
                <tr>
                    <td>Contact Phone</td>
                    <td>
                        <a href="tel:{{ $user->full_contact_phone }}"
                            class=" link-primary">{{ $user->full_contact_phone }}</a>
                    </td>
                </tr>
                <tr>
                    <td>Total Orders</td>
                    <td>{{ $totalOrders }}</td>
                </tr>
                <tr>
                    <td>Notes</td>
                    <td>{{ $user->notes }}</td>
                </tr>
            </table>
        </div>


    </div>
@endsection
