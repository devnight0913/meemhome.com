<div class="border rounded-4 p-3 mb-3 bg-white shadow-sm border text-center">

    <div class="mb-3">
        <img src="{{ isset($user) ? $user->profile_photo_url_medium : asset('/images/webp/placeholder.webp') }}"
            class="object-fit-cover rounded-circle cursor-pointer border" alt="image" width="100" height="100"
            id="profile-photo">

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
        @isset($user)
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
        @endisset
    </div>
    <input type="file" name="photo" id="input-profile-photo" class="d-none" accept="image/x-png,image/jpeg">

</div>

<div class="border rounded-4 p-3 mb-3 bg-white border-light shadow-sm">
    <div class="form-label fw-bold mb-3">Profile</div>
    @isset($user)
        @if ($user->is_super_admin)
            <div class="mb-3 text-danger fw-bold text-center">
                Super Admin Role and Permissions cannot be edited!
            </div>
        @endif
    @endisset


    <div class="mb-3">
        <label for="role" class="form-label fw-bold">Role</label>
        <select class="form-select" name="role" id="role" @disabled(isset($user) ? $user->is_super_admin : false )>
            @isset($user)
                @foreach ($roles as $role)
                    <option value="{{ $role->id }}" @selected($role->id == $user->role_id)>
                        {{ $role->name }}
                    </option>
                @endforeach
            @else
                @foreach ($roles as $role)
                    <option value="{{ $role->id }}" @selected($role->selected)>
                        {{ $role->name }}
                    </option>
                @endforeach
            @endisset
        </select>
        @error('role')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="mb-3" id="permissions-select-section">
        <label for="permissions" class="form-label fw-bold">
            Permissions
            <span class="btn btn-info btn-xs select-all me-2">Select all</span>
            <span class="btn btn-info btn-xs deselect-all">Deselect all</span></label>
        </label>
        <select name="permissions[]" id="permissions-select" multiple @disabled(isset($user) ? $user->is_super_admin : false )>
            @foreach ($permissions as $permission)
                <option value="{{ $permission->id }}" @selected(isset($user) ? $user->permissions->contains($permission->id) : true)>
                    {{ $permission->name }}
                </option>
            @endforeach
        </select>
        @error('permissions')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
    <div class="mb-3">
        <label for="name" class="form-label fw-bold"> Name</label>
        <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name"
            value="{{ old('name', isset($user) ? $user->name : '') }}" required>
        @error('name')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
    <div class="row">
        <div class="col-md-6 mb-3">
            <label for="birthday" class="form-label fw-bold"> Birthday</label>
            <input type="date" class="form-control @error('birthday') is-invalid @enderror" id="birthday"
                name="birthday" value="{{ old('birthday', isset($user) ? $user->birthday : '') }}">
            @error('birthday')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
        <div class="col-md-6 mb-3">
            <label for="gender" class="form-label fw-bold">Gender</label>
            <select class="form-select @error('gender') is-invalid @enderror" id="gender" name="gender">
                @isset($user)
                    <option value="" @selected(is_null($user->gender))></option>
                    <option value="male" @selected($user->is_male)>Male</option>
                    <option value="female" @selected($user->is_female)>Female</option>
                @else
                    <option value="" selected></option>
                    <option value="male">Male</option>
                    <option value="female">Female</option>
                @endisset
            </select>
            @error('role')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
    </div>
</div>

@push('script')
    @isset($user)
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
    @endisset
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
@endpush
