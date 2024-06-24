<form aaction="{{ route('admin.users.store') }}" method="POST" role="form" enctype="multipart/form-data">
    @csrf
    @isset($user)
        @method('PUT')
    @endisset
    <div class="d-flex align-items-center mb-3">
        <div class="flex-grow-1 h5 fw-bold m-0">
            @isset($user)
                <div class="d-flex align-items-center">
                    <div class="me-2">
                        <img src="{{ $user->profile_photo_url_small }}" alt="{{ $user->name }}"
                            class="profile-photo rounded-circle me-1 border" height="45">
                    </div>
                    <div>
                        <div class="fw-bold h5 mb-0">{{ $user->name }}</div>
                        <div class="text-muted small">
                            ID: <span class="fw-bold">{{ $user->id }}</span>
                        </div>
                    </div>
                </div>
            @else
                Create User
            @endisset
        </div>
        <button class="btn btn-primary px-md-4 ms-auto" type="submit">Save</button>
    </div>

    @include('admin.users.partials.profile')
    @include('admin.users.partials.login')
    @include('admin.users.partials.delivery-address')
    {{-- @include('admin.users.partials.deposit') --}}
    @include('admin.users.partials.contact')
    @include('admin.users.partials.others')

</form>
@isset($user)
    <form action="{{ route('admin.user.profile-photo.destroy', $user) }}" method="POST" id="form-profile-photo">
        @csrf
        @method('DELETE')
    </form>
@endisset

@push('script')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            let selectElement = document.querySelectorAll('[name=sel1]');

            var slimSelect = new SlimSelect({
                select: '#permissions-select',
            });

            var permissionsSelect = document.querySelector("#permissions-select");
            let optionValues = [...permissionsSelect.options].map(o => o.value);
            var currentData = optionValues;

            var roleSelect = document.querySelector('#role');
            var permissionsSelectSection = document.querySelector('#permissions-select-section');
            if (roleSelect.value == '2') {
                permissionsSelectSection.classList.remove('d-none')
            } else {
                permissionsSelectSection.classList.add('d-none')
            }

            roleSelect.addEventListener("change", function() {
                if (this.value == '2') {
                    permissionsSelectSection.classList.remove('d-none')
                } else {
                    permissionsSelectSection.classList.add('d-none')
                }
            });

            var deselectBtn = document.querySelector('.deselect-all');
            deselectBtn.addEventListener("click", function() {
                slimSelect.set([])
            });

            var selectAllBtn = document.querySelector('.select-all');
            selectAllBtn.addEventListener("click", function() {
                slimSelect.set(currentData);
            });


        });
    </script>
@endpush
