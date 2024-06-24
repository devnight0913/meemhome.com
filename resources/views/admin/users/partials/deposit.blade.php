<div class="border rounded-4 p-3 mb-3 bg-white border-light shadow-sm">
    <div class=" mb-3">
        <label for="deposit" class="form-label fw-bold"> Deposit </label>
        <div class="position-relative">
            <input type="number" class="form-control ps-4 @error('deposit') is-invalid @enderror" step="0.01"
                min="0" id="deposit" name="deposit" placeholder="0.00" autocomplete="off"
                value="{{ old('deposit', isset($user) ? $user->deposit : 0) }}" required />
            <div class="position-absolute top-50 start-0 translate-middle-y p-2 text-muted user-select-none">
                $
            </div>
        </div>
        @error('deposit')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
</div>
