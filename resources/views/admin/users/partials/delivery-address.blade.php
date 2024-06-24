<div class="border rounded-4 p-3 mb-3 bg-white border-light shadow-sm">
    <div class="form-label fw-bold mb-3">Delivery Address</div>


    <div class="mb-3">
        <label for="area" class="form-label fw-bold">Area</label>
        <select class="form-select" name="area" id="area">
            @isset($user)
                <option value="" selected></option>
                @foreach ($areas as $area)
                    <option value="{{ $area->id }}" @selected($area->id == $user->area_id)>
                        {{ $area->name }}
                    </option>
                @endforeach
            @else
                <option value="" selected></option>
                @foreach ($areas as $area)
                    <option value="{{ $area->id }}">
                        {{ $area->name }}
                    </option>
                @endforeach
            @endisset
        </select>
        @error('area')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>


    <div class="mb-3">
        <label for="address" class="form-label fw-bold">Address</label>
        <textarea class="form-control @error('address') is-invalid @enderror" id="address" name="address">{{ old('address', isset($user) ? $user->address : '') }}</textarea>
        @error('address')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

</div>
