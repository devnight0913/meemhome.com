@push('head')
    <link rel="preload" href="https://unpkg.com/air-datepicker@3.3.5/air-datepicker.css" as="style" />
    <link rel="stylesheet" href="https://unpkg.com/air-datepicker@3.3.5/air-datepicker.css">
    <link rel="preload" href="{{ asset('BVSelect/css/bvselect.css') }}" as="style" />
    <link rel="stylesheet" href="{{ asset('BVSelect/css/bvselect.css') }}">
    <script src="https://unpkg.com/air-datepicker@3.3.5/air-datepicker.js"></script>
    <script src="{{ asset('BVSelect/js/bvselect.js') }}"></script>
    <style>
        .bv_atual {
            border-radius: 0px !important;
            border: 1px solid #ced4da !important;
        }

        .bv_mainselect {
            padding: 0 !important;

        }


        .bv_ul_inner {
            margin-top: 0 !important;
            border-radius: 0 !important;
        }
    </style>
@endpush

<form
    action="{{ isset($number) ? route('admin.serial_numbers.update', $number) : route('admin.serial_numbers.store') }}"
    method="POST">
    @csrf

    @isset($number)
        @method('PUT')
    @endisset

    <div class="mb-3">
        <label for="product" class="form-label fw-bold">Product*</label>
        <select id="selectbox" name="product">
            @foreach ($items as $item)
                <option data-img="{{ $item->image_url }}" value="{{ $item->id }}" @selected(isset($number) ? $number->item_id == $item->id : false)>
                    {{ $item->name }} @if ($item->code)
                        ({{ $item->code }})
                    @endif
                </option>
            @endforeach
        </select>
        @error('product')
            <div class="text-danger small">{{ $message }}</div>
        @enderror
    </div>


    <div class="mb-3">
        <label for="serial_numbers" class="form-label fw-bold">Serial Numbers*</label>
        <textarea class="form-control  @error('serial_numbers') is-invalid @enderror rounded-0" rows="7" id="serial_numbers" name="serial_numbers">{{ old('serial_numbers', isset($number) ? $number->exploded_serial_numbers : '') }}</textarea>
        @error('serial_numbers')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>


    <div class="mb-3">
        <label for="warranty_end_date" class="form-label fw-bold">Warranty End Date*</label>
        <input type="text" class="form-control cursor-pointer @error('warranty_end_date') is-invalid @enderror"
            id="warranty-date" name="warranty_end_date" placeholder="Choose Date" autocomplete="off"
            value="{{ old('warranty_end_date', isset($number) ? $number->warranty_end_date_view : '') }}" readonly>
        <div class="form-text">Choose when Warranty Ends</div>

        @error('warranty_end_date')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>


    <div class="mb-3">
        <label for="purchase_date" class="form-label fw-bold">Purchase Date</label>
        <input type="text" class="form-control cursor-pointer @error('purchase_date') is-invalid @enderror"
            id="purchase-date" name="purchase_date" placeholder="Choose Date" autocomplete="off"
            value="{{ old('purchase_date', isset($number) ? $number->purchase_date_view : '') }}" readonly>
        <div class="form-text">Choose when the customer purchased the product</div>
        @error('purchase_date')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
    <div class="mb-3">
        <label for="notes" class="form-label fw-bold">Notes</label>
        <textarea class="form-control  @error('notes') is-invalid @enderror rounded-0" id="notes" name="notes">{{ old('notes', isset($number) ? $number->notes : '') }}</textarea>
        @error('notes')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>



    <button type="submit" class="btn btn-primary px-4 d-flex align-items-center justify-content-center">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"
            class="hero-icon me-2">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4"></path>
        </svg> Save Serial Number
    </button>
</form>
@push('script')
    <script>
        var localeEn = {
            days: ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'],
            daysShort: ['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'],
            daysMin: ['Su', 'Mo', 'Tu', 'We', 'Th', 'Fr', 'Sa'],
            months: ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September',
                'October', 'November', 'December'
            ],
            monthsShort: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
            today: 'Today',
            clear: 'Clear',
            dateFormat: 'MM/dd/yyyy',
            timeFormat: 'hh:mm aa',
            firstDay: 0
        };
        var format = 'dd MMMM yyyy';



        document.addEventListener("DOMContentLoaded", function() {

            new AirDatepicker('#warranty-date', {
                locale: localeEn,
                dateFormat: format,
                autoClose: true
            });
            new AirDatepicker('#purchase-date', {
                locale: localeEn,
                dateFormat: format,
                buttons: ['clear'],
                autoClose: true
            });
            var selectbox = new BVSelect({
                selector: "#selectbox",
                width: "100%",
                searchbox: true,
                offset: false,
                placeholder: "Select a product",
                search_placeholder: "Search...",
                search_autofocus: true,
                breakpoint: 450
            });
        });
    </script>
    @isset($number)
        <script>
            document.addEventListener("DOMContentLoaded", function() {
                var selectboxOptions = document.querySelector('#selectbox');
                selectboxOptions.value = "{{ $number->item_id }}";

                var innerSelect = document.querySelector('.bv_atual');
                innerSelect.innerHTML = "{{ $number->item->name }}";
            });
        </script>
    @endisset
@endpush
