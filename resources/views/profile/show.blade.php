@extends('layouts.app')
@section('title', 'Profile | ' . $user->name)
@section('content')
    @foreach ($errors->all() as $error)
        {{ $error }}<br />
    @endforeach

    <section>
        <div class="h4 ff-poppins">Profile Information</div>
        <div class="mb-3 text-muted">Update Your Profile Information and Email Address</div>
        <form action="{{ route('user.profile-information.update') }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="border rounded-4 p-3 mb-3 bg-white shadow-sm border text-center">

                <div class="mb-3">
                    <img src="{{ $user->profile_photo_url_medium }}"
                        class="object-fit-cover rounded-circle cursor-pointer border" alt="image" width="100"
                        height="100" id="profile-photo" data-bs-toggle="modal" data-bs-target="#imageModal">

                    @error('photo')
                        <div class="text-danger">
                            {{ $message }}
                        </div>
                    @enderror
                </div>


                <div>
                    <label class="fw-bold form-label" for="input-profile-photo">
                        <a type="button" class="btn btn-primary text-light px-4 mb-3">
                            Choose Profile Photo
                        </a>
                    </label>

                    @if ($user->profile_photo_path)
                        <button type="button" class="btn btn-danger text-light mb-3 ms-2" data-bs-toggle="modal"
                            data-bs-target="#removePhotoConfirmModal">
                            Remove Image
                        </button>

                        <div class="modal" id="removePhotoConfirmModal" tabindex="-1"
                            aria-labelledby="removePhotoConfirmModalLabel" aria-hidden="true">
                            <div class="modal-dialog  modal-dialog-centered">
                                <div class="modal-content">
                                    <div class="modal-body">
                                        <h4>Are You sure you want to remove your photo?</h4>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-light border border-1 px-4"
                                            data-bs-dismiss="modal">Nevermind</button>
                                        <button type="button" id="btn-remove-profile-photo"
                                            class="btn btn-primary border px-4">Remove</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
                <input type="file" name="photo" id="input-profile-photo" class="d-none"
                    accept="image/x-png,image/jpeg">

            </div>

            <div class="border rounded-4 p-3 mb-3 bg-white shadow-sm border">
                <div class="form-label fw-bold mb-3">Profile</div>
                <div class="mb-3">
                    <label for="name" class="form-label fw-bold"> Name*</label>
                    <input type="text" class="form-control @error('name') is-invalid @enderror" id="name"
                        name="name" value="{{ old('name', $user->name) }}" required>
                    @error('name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="email" class="form-label fw-bold"> Email*</label>
                    <input type="email" class="form-control @error('email') is-invalid @enderror" id="email"
                        name="email" value="{{ old('email', $user->email) }}" required>
                    @error('email')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="phone" class="form-label fw-bold"> Phone</label>
                    <input type="tel" class="form-control @error('phone') is-invalid @enderror" id="phone"
                        name="phone" value="{{ $user->phone }}">
                    @error('phone')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <input type="hidden" name="phone_dial_code" id="input-phone-dial-code">
                <input type="hidden" name="phone_iso2" id="input-phone-iso2">

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="birthday" class="form-label fw-bold">Birthday</label>
                        <input type="date" class="form-control @error('birthday') is-invalid @enderror" id="birthday"
                            name="birthday" value="{{ old('birthday', $user->birthday) }}">
                        @error('birthday')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="gender" class="form-label fw-bold">Gender</label>
                        <select class="form-select @error('gender') is-invalid @enderror" id="gender" name="gender">
                            <option value="" @selected(is_null($user->gender))></option>
                            <option value="male" @selected($user->is_male)>Male</option>
                            <option value="female" @selected($user->is_female)>Female</option>
                        </select>
                        @error('role')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>

            <div class="border rounded-4 p-3 mb-3 bg-white shadow-sm border">
                <div class="form-label fw-bold mb-3">Delivery Address</div>


                <div class="mb-3">
                    <label for="area" class="form-label fw-bold">Area</label>
                    <select class="form-select" name="area" id="area">

                        <option value="" selected></option>
                        @foreach ($areas as $area)
                            <option value="{{ $area->id }}" @selected($area->id == $user->area_id)>
                                {{ $area->name }}
                            </option>
                        @endforeach

                    </select>
                    @error('area')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>


                <div class="mb-3">
                    <label for="address" class="form-label fw-bold">Address</label>
                    <textarea class="form-control @error('address') is-invalid @enderror" id="address" name="address">{{ old('address', $user->address) }}</textarea>
                    @error('address')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

            </div>


            <div class="border rounded-4 p-3 mb-3 bg-white shadow-sm border">
                <div class="form-label fw-bold mb-3">Contact</div>

                <div class="mb-3">
                    <label for="contact_email" class="form-label fw-bold">Contact Email</label>
                    <input type="email" class="form-control @error('contact_email') is-invalid @enderror"
                        id="contact_email" name="contact_email"
                        value="{{ old('contact_email', $user->contact_email) }}">
                    @error('contact_email')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="contact_phone" class="form-label fw-bold">Contact Phone</label>
                    <input type="tel" class="form-control @error('contact_phone') is-invalid @enderror"
                        id="contact_phone" name="contact_phone"
                        value="{{ old('contact_phone', $user->contact_phone) }}">
                    @error('contact_phone')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <input type="hidden" name="contact_phone_dial_code" id="input-contact-phone-dial-code">
                <input type="hidden" name="contact_phone_iso2" id="input-contact-phone-iso2">
            </div>


            <div class="d-flex">
                <button type="submit" class="btn btn-primary px-md-4 ms-auto">Save</button>
            </div>

        </form>
    </section>
    <form action="{{ route('user.profile-photo.destroy') }}" method="POST" id="form-profile-photo">
        @csrf
        @method('DELETE')
    </form>


    @if (!$user->is_admin)
        <hr class="mt-5">
        <div class="py-5">
            <div class="h4 ff-poppins">Delete Your Account</div>
            <div class="mb-3"> Permently Delete Your Account</div>
            <button class="btn btn-danger text-light px-4" data-bs-toggle="modal" data-bs-target="#passwordConfirmModal">
                Delete Account
            </button>

            <div class="modal" id="passwordConfirmModal" tabindex="-1" aria-labelledby="passwordConfirmModalLabel"
                aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content ">
                        <div class="modal-header border-0">
                            <h5 class="modal-title" id="passwordConfirmModalLabel">Confirm Password</h5>
                        </div>
                        <form action="{{ route('user.destroy') }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <div class="modal-body pt-0">
                                <p>For your security, Please, confirm your password.</p>
                                <div class="mb-3">
                                    <input type="password" class="form-control" placeholder="Password" name="password"
                                        id="password" aria-labelledby="Password" required>
                                    @error('password')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-light border px-4"
                                    data-bs-dismiss="modal">Nevermind</button>
                                <button type="submit" class="btn btn-primary px-4">Confirm</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    @endif

    <div class="modal" id="imageModal" tabindex="-1" aria-labelledby="imageModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-body p-0">
                    <img src="{{ $user->profile_photo_url_large }}" class="object-fit-cover cursor-pointer w-100"
                        alt="image" height="700">
                </div>
            </div>
        </div>
    </div>

@endsection
@push('script')
    @if ($user->profile_photo_path)
        <script type="text/javascript">
            document.addEventListener("DOMContentLoaded", function() {
                var btnRemovePhoto = document.querySelector('#btn-remove-profile-photo');
                btnRemovePhoto.addEventListener('click', function() {
                    btnRemovePhoto.disabled = true;
                    topbar.show();
                    document.querySelector('#form-profile-photo').submit();
                });
            });
        </script>
    @endif
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            var profilePhotoInput = document.querySelector('#input-profile-photo');
            if (profilePhotoInput) {
                profilePhotoInput.addEventListener('change', function(event) {
                    readEditURL(this, document.querySelector('#profile-photo'));
                });
            }

            function readEditURL(input, image) {
                if (input.files && input.files[0]) {
                    var reader = new FileReader();

                    reader.onload = function(e) {
                        image.src = e.target.result;
                    }
                    reader.readAsDataURL(input.files[0]);
                }
            }
        });
    </script>

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
