<div class="border rounded-4 p-3 mb-3 bg-white border-light shadow-sm">
    <div class="form-label fw-bold mb-3">Login</div>

    <div class="mb-3">
        <label for="email" class="form-label fw-bold"> Email</label>
        <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email"
            value="{{ old('email', isset($user) ? $user->email : '') }}" required>
        @error('email')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
    <div class="mb-3">
        <label for="phone" class="form-label fw-bold"> Phone</label>
        <input type="tel" class="form-control @error('phone') is-invalid @enderror" id="phone" name="phone"
            value="{{ old('phone', isset($user) ? $user->phone : '') }}">
        @error('phone')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
    <input type="hidden" name="phone_dial_code" id="input-phone-dial-code">
    <input type="hidden" name="phone_iso2" id="input-phone-iso2">

    @empty($user)
        <div class="mb-3">
            <label for="password" class="form-label fw-bold">Password</label>
            <input type="password" autocomplete="off" class="form-control @error('password') is-invalid @enderror"
                id="password" name="password" required>
            @error('password')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
        <div class="mb-3">
            <label for="password_confirmation" class="form-label fw-bold"> Confirm Password</label>
            <input type="password" autocomplete="off"
                class="form-control @error('password_confirmation') is-invalid @enderror" id="password_confirmation"
                name="password_confirmation" required>
            @error('password_confirmation')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
    @endempty
</div>
