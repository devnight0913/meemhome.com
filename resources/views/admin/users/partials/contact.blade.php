<div class="border rounded-4 p-3 mb-3 bg-white border-light shadow-sm">
    <div class="form-label fw-bold mb-3">Contact</div>

    <div class="mb-3">
        <label for="contact_email" class="form-label fw-bold">Contact Email</label>
        <input type="email" class="form-control @error('contact_email') is-invalid @enderror" id="contact_email"
            name="contact_email" value="{{ old('contact_email', isset($user) ? $user->contact_email : '') }}">
        @error('contact_email')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
    <div class="mb-3">
        <label for="contact_phone" class="form-label fw-bold">Contact Phone</label>
        <input type="tel" class="form-control input-contact-phone @error('contact_phone') is-invalid @enderror"
            id="contact_phone" name="contact_phone"
            value="{{ old('contact_phone', isset($user) ? $user->contact_phone : '') }}">
        @error('contact_phone')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
    <input type="hidden" name="contact_phone_dial_code" id="input-contact-phone-dial-code">
    <input type="hidden" name="contact_phone_iso2" id="input-contact-phone-iso2">

</div>
