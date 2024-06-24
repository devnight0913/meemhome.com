@extends('admin.layouts.app')
@section('title', 'Edit User')

@section('content')
    @include('admin.users.partials.form')
@endsection
@push('script')
    <script>
        var inputUserContactPhone = document.querySelector('#contact_phone');
        var inputUserContactIso2 = document.querySelector('#input-contact-phone-iso2');
        var inputUserContactDialCode = document.querySelector('#input-contact-phone-dial-code');

        inputUserContactIso2.value = "{{ $user->contact_phone_iso2 ?? 'lb' }}";
        inputUserContactDialCode.value = "{{ $user->contact_phone_dial_code ?? '961' }}";

        if (inputUserContactPhone) {
            var contactIti = intlTelInput(inputUserContactPhone, {
                initialCountry: "{{ $user->contact_phone_iso2 ?? 'lb' }}",
                preferredCountries: ['lb', 'fr', 'us', 'gb'],
                separateDialCode: true,
            });
        }

        inputUserContactPhone.addEventListener("countrychange", function() {
            inputUserContactIso2.value = contactIti.getSelectedCountryData().iso2;
            inputUserContactDialCode.value = contactIti.getSelectedCountryData().dialCode;
        });

        var inputUserPhone = document.querySelector('#phone');
        var inputUserIso2 = document.querySelector('#input-phone-iso2');
        var inputUserDialCode = document.querySelector('#input-phone-dial-code');

        inputUserIso2.value = "{{ $user->phone_iso2 ?? 'lb' }}";
        inputUserDialCode.value = "{{ $user->phone_dial_code ?? '961' }}";

        if (inputUserPhone) {
            var Iti = intlTelInput(inputUserPhone, {
                initialCountry: "{{ $user->phone_iso2 ?? 'lb' }}",
                preferredCountries: ['lb', 'fr', 'us', 'gb'],
                separateDialCode: true,
            });
        }

        inputUserPhone.addEventListener("countrychange", function() {
            inputUserIso2.value = Iti.getSelectedCountryData().iso2;
            inputUserDialCode.value = Iti.getSelectedCountryData().dialCode;
        });
    </script>
@endpush
