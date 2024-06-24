{{-- <li>
    <div class="dropdown-item py-2 border-bottom">
        <div class="d-flex align-items-center">
            <div class="me-2">
                <img src="{{ Auth::user()->profile_photo_url_small }}" alt="{{ Auth::user()->name }}"
                    class="profile-photo rounded-circle border" height="60">
            </div>
            <div>
                <div class="small text-muted">{{ Auth::user()->name }} </div>
                <div>{{ Auth::user()->email }} </div>

            </div>
        </div>
    </div>
</li> --}}
@admin
    <li>
        <a class="dropdown-item py-2" href="{{ route('admin.dashboard') }}">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                class="me-2" style="width:1.5rem;height:1.5rem;">
                <path stroke-linecap="round" stroke-linejoin="round"
                    d="M10.5 6h9.75M10.5 6a1.5 1.5 0 11-3 0m3 0a1.5 1.5 0 10-3 0M3.75 6H7.5m3 12h9.75m-9.75 0a1.5 1.5 0 01-3 0m3 0a1.5 1.5 0 00-3 0m-3.75 0H7.5m9-6h3.75m-3.75 0a1.5 1.5 0 01-3 0m3 0a1.5 1.5 0 00-3 0m-9.75 0h9.75" />
            </svg>
            Admin Panel
        </a>
    </li>
@endadmin
<li>
    <hr class="dropdown-divider m-0">
</li>
<li>
    <a class="dropdown-item py-2" href="{{ route('cart') }}">

        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
            stroke="currentColor" style="width:1.5rem;height:1.5rem;" class="me-2">
            <path stroke-linecap="round" stroke-linejoin="round"
                d="M2.25 3h1.386c.51 0 .955.343 1.087.835l.383 1.437M7.5 14.25a3 3 0 00-3 3h15.75m-12.75-3h11.218c1.121-2.3 2.1-4.684 2.924-7.138a60.114 60.114 0 00-16.536-1.84M7.5 14.25L5.106 5.272M6 20.25a.75.75 0 11-1.5 0 .75.75 0 011.5 0zm12.75 0a.75.75 0 11-1.5 0 .75.75 0 011.5 0z" />
        </svg>

        @lang('Cart')
    </a>
</li>
<li>
    <a class="dropdown-item py-2" href="{{ route('user.orders.index') }}">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
            stroke="currentColor" class="me-2" style="width:1.5rem;height:1.5rem;">
            <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z" />
        </svg>
        @lang('Purchase History')
    </a>
</li>
<li>
    <hr class="dropdown-divider m-0">
</li>
<li>
    <a class="dropdown-item py-2" href="{{ route('user.profile') }}">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
            stroke="currentColor" class="me-2" style="width:1.5rem;height:1.5rem;">
            <path stroke-linecap="round" stroke-linejoin="round"
                d="M17.982 18.725A7.488 7.488 0 0012 15.75a7.488 7.488 0 00-5.982 2.975m11.963 0a9 9 0 10-11.963 0m11.963 0A8.966 8.966 0 0112 21a8.966 8.966 0 01-5.982-2.275M15 9.75a3 3 0 11-6 0 3 3 0 016 0z" />
        </svg>
        Profile
    </a>
</li>
<li>
    <a class="dropdown-item py-2" href="{{ route('password-change') }}">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
            stroke="currentColor" class="me-2" style="width:1.5rem;height:1.5rem;">
            <path stroke-linecap="round" stroke-linejoin="round"
                d="M16.5 10.5V6.75a4.5 4.5 0 10-9 0v3.75m-.75 11.25h10.5a2.25 2.25 0 002.25-2.25v-6.75a2.25 2.25 0 00-2.25-2.25H6.75a2.25 2.25 0 00-2.25 2.25v6.75a2.25 2.25 0 002.25 2.25z" />
        </svg>
        Change Password
    </a>
</li>
<li>
    <hr class="dropdown-divider m-0">
</li>
<li>
    <a class="dropdown-item py-2" href="{{ route('logout') }}"
        onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
            stroke="currentColor" class="me-2" style="width:1.5rem;height:1.5rem;">
            <path stroke-linecap="round" stroke-linejoin="round"
                d="M15.75 9V5.25A2.25 2.25 0 0013.5 3h-6a2.25 2.25 0 00-2.25 2.25v13.5A2.25 2.25 0 007.5 21h6a2.25 2.25 0 002.25-2.25V15M12 9l-3 3m0 0l3 3m-3-3h12.75" />
        </svg>
        Log Out
    </a>
    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
        @csrf
    </form>
</li>
