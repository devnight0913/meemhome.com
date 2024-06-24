<div class="border rounded-4 p-3 mb-3 bg-white border-light shadow-sm">
    <div class="form-label fw-bold mb-3">Others</div>

    <div class="mb-3">
        <label for="notes" class="form-label fw-bold">Notes</label>
        <textarea class="form-control @error('notes') is-invalid @enderror" id="notes" name="notes">{{ old('notes', isset($user) ? $user->notes : '') }}</textarea>
        @error('notes')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

</div>
