@extends('layouts.app')

@section('content')
<div class="d-flex flex-column flex-lg-row-fluid p-10">
    <div class="d-flex flex-center flex-column flex-lg-row-fluid">
        <div class="w-lg-700px p-10">

            <!-- Encabezado -->
            <div class="text-center mb-10">
                <h1 class="fw-bolder text-dark mb-3">Account Settings</h1>
                <div class="text-muted fw-semibold fs-6">Manage your profile, password, and account options</div>
            </div>

            <!-- Tabs -->
            <ul class="nav nav-tabs nav-line-tabs mb-10 fs-6 fw-semibold" id="profileTabs" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active" id="profile-tab" data-bs-toggle="tab"
                        data-bs-target="#profile" type="button" role="tab">Profile Info</button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="password-tab" data-bs-toggle="tab"
                        data-bs-target="#password" type="button" role="tab">Update Password</button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link text-danger" id="delete-tab" data-bs-toggle="tab"
                        data-bs-target="#delete" type="button" role="tab">Delete Account</button>
                </li>
            </ul>

            <!-- Contenido Tabs -->
            <div class="tab-content" id="profileTabsContent">

                <!-- ================== TAB PROFILE ================== -->
                <div class="tab-pane fade show active" id="profile" role="tabpanel">
                    <form method="POST" action="{{ route('profile.update') }}" class="form" enctype="multipart/form-data">
                        @csrf
                        @method('PATCH')

                        <!-- Name -->
                        <div class="fv-row mb-8">
                            <label class="form-label fw-semibold">Name</label>
                            <input type="text" name="name" value="{{ old('name', $user->name) }}"
                                class="form-control bg-transparent @error('name') is-invalid @enderror" required autofocus>
                            @error('name') <div class="text-danger mt-1">{{ $message }}</div> @enderror
                        </div>

                        <!-- Email -->
                        <div class="fv-row mb-8">
                            <label class="form-label fw-semibold">Email</label>
                            <input type="email" name="email" value="{{ old('email', $user->email) }}"
                                class="form-control bg-transparent @error('email') is-invalid @enderror" required>
                            @error('email') <div class="text-danger mt-1">{{ $message }}</div> @enderror

                            @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && !$user->hasVerifiedEmail())
                                <div class="mt-3">
                                    <p class="text-gray-600">Your email address is unverified.</p>
                                    <button form="send-verification" class="btn btn-sm btn-light-primary">Resend Verification</button>
                                    @if (session('status') === 'verification-link-sent')
                                        <div class="text-success fw-semibold mt-2">Verification link sent!</div>
                                    @endif
                                </div>
                            @endif
                        </div>

                        <div class="alert alert-warning">
                            <strong>Warning:</strong> Keep in mind that the selected city will be set as the default for your listings.
                        </div>

                        <div x-data="locationData()" x-init="init()" class="row">

                            <!-- Province -->
                            <div class="col-md-6 fv-row mb-8">
                                <label for="state" class="required fs-6 fw-semibold mb-2">Province</label>
                                <select id="state"
                                        name="state_id"
                                        x-model="selectedState"
                                        @change="fetchCities();"
                                        class="form-select @error('state_id') is-invalid @enderror"
                                        data-placeholder="Select a Province"
                                        required>
                                    <option></option>
                                    <template x-for="state in states" :key="state.id">
                                        <option :value="state.id" x-text="state.name"></option>
                                    </template>
                                </select>
                                @error('state_id')
                                <div class="text-danger mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- City -->
                            <div class="col-md-6 fv-row mb-8">
                                <label for="city" class="required fs-6 fw-semibold mb-2">City</label>
                                <select id="city"
                                        name="city_id"
                                        x-model="selectedCity"
                                        class="form-select @error('city_id') is-invalid @enderror"
                                        data-placeholder="Selec a City"
                                        required>
                                    <option></option>
                                    <template x-for="city in cities" :key="city.id">
                                        <option :value="city.id" x-text="city.name"></option>
                                    </template>
                                </select>
                                @error('city_id')
                                <div class="text-danger mt-1">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="fv-row mb-10">
                            <!--begin::Label-->
                            <label class="d-block fw-semibold fs-6 mb-5">
                                <span class="required">Image</span>
                                <i class="fas fa-exclamation-circle ms-2 fs-7" data-bs-toggle="tooltip" title="Select an image that best represents yourself."></i>
                            </label>
                            <!--end::Label-->
                            <!--begin::Image input placeholder-->
                            <style>.image-input-placeholder { background-image: url("{{ asset('template/assets/media/svg/files/blank-image.svg') }}"); } [data-bs-theme="dark"] .image-input-placeholder { background-image: url("{{ asset('template/assets/media/svg/files/blank-image-dark.svg') }}"); }</style>
                            <!--end::Image input placeholder-->
                            <!--begin::Image input-->
                            <div class="image-input image-input-empty image-input-outline image-input-placeholder" data-kt-image-input="true">
                                <!--begin::Preview existing image-->
                                <div class="image-input-wrapper w-225px h-225px" style="background-image: url('{{ $user->avatar }}')"> </div>
                                <!--end::Preview existing image-->
                                <!--begin::Label-->
                                <label class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow" data-kt-image-input-action="change" data-bs-toggle="tooltip" title="Change image">
                                    <i class="bi bi-pencil-fill fs-7"></i>
                                    <!--begin::Inputs-->
                                    <input type="file" name="image" accept=".png, .jpg, .jpeg" />
                                    <input type="hidden" name="event_remove" />
                                    <!--end::Inputs-->
                                </label>
                                <!--end::Label-->
                                <!--begin::Cancel-->
                                <span class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow" data-kt-image-input-action="cancel" data-bs-toggle="tooltip" title="Cancel image">
                                    <i class="bi bi-x fs-2"></i>
                                </span>
                                <!--end::Cancel-->
                                <!--begin::Remove-->
                                <span class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow" data-kt-image-input-action="remove" data-bs-toggle="tooltip" title="Remove image">
                                    <i class="bi bi-x fs-2"></i>
                                </span>
                                <!--end::Remove-->
                            </div>
                            <!--end::Image input-->
                            <!--begin::Hint-->
                            <div class="form-text">Allowed file types: png, jpg, jpeg.</div>
                            <!--end::Hint-->
                        </div>

                        <!-- Botón -->
                        <div class="d-flex justify-content-end">
                            <button type="submit" class="btn btn-primary">Save</button>
                        </div>

                        @if (session('status') === 'profile-updated')
                            <div class="alert alert-success mt-3">Profile updated successfully!</div>
                        @endif
                    </form>
                </div>

                <!-- ================== TAB PASSWORD ================== -->
                <div class="tab-pane fade" id="password" role="tabpanel">
                    <form method="POST" action="{{ route('password.update') }}" class="form">
                        @csrf
                        @method('PUT')

                        <!-- Current Password -->
                        <div class="fv-row mb-8">
                            <label class="form-label fw-semibold">Current Password</label>
                            <input type="password" name="current_password"
                                class="form-control bg-transparent @error('current_password','updatePassword') is-invalid @enderror">
                            @error('current_password','updatePassword') <div class="text-danger mt-1">{{ $message }}</div> @enderror
                        </div>

                        <!-- New Password -->
                        <div class="fv-row mb-8">
                            <label class="form-label fw-semibold">New Password</label>
                            <input type="password" name="password"
                                class="form-control bg-transparent @error('password','updatePassword') is-invalid @enderror">
                            @error('password','updatePassword') <div class="text-danger mt-1">{{ $message }}</div> @enderror
                        </div>

                        <!-- Confirm Password -->
                        <div class="fv-row mb-8">
                            <label class="form-label fw-semibold">Confirm Password</label>
                            <input type="password" name="password_confirmation"
                                class="form-control bg-transparent @error('password_confirmation','updatePassword') is-invalid @enderror">
                            @error('password_confirmation','updatePassword') <div class="text-danger mt-1">{{ $message }}</div> @enderror
                        </div>

                        <!-- Botón -->
                        <div class="d-flex justify-content-end">
                            <button type="submit" class="btn btn-primary">Save</button>
                        </div>

                        @if (session('status') === 'password-updated')
                            <div class="alert alert-success mt-3">Password updated successfully!</div>
                        @endif
                    </form>
                </div>

                <!-- ================== TAB DELETE ================== -->
                <div class="tab-pane fade" id="delete" role="tabpanel">
                    <div class="alert alert-warning">
                        <strong>Warning:</strong> Once your account is deleted, all of its data will be permanently removed.
                    </div>

                    <!-- Trigger modal -->
                    <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#deleteAccountModal">
                        Delete Account
                    </button>

                    <!-- Modal -->
                    <div class="modal fade" id="deleteAccountModal" tabindex="-1" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content">
                                <form method="POST" action="{{ route('profile.destroy') }}">
                                    @csrf
                                    @method('DELETE')

                                    <div class="modal-header">
                                        <h5 class="modal-title text-danger">Confirm Account Deletion</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>

                                    <div class="modal-body">
                                        <p>Please enter your password to confirm account deletion:</p>
                                        <div class="fv-row mb-5">
                                            <input type="password" name="password"
                                                class="form-control @error('password','userDeletion') is-invalid @enderror"
                                                placeholder="Password">
                                            @error('password','userDeletion') <div class="text-danger mt-1">{{ $message }}</div> @enderror
                                        </div>
                                    </div>

                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
                                        <button type="submit" class="btn btn-danger">Delete Account</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div> <!-- end modal -->
                </div>

            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
    <!--To use Alpine.js-->
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>

    <script>
        function locationData() {
            return {
                states: [],
                cities: [],
                selectedState: null,
                selectedCity: null,
                countryId: 39,

                init() {
                    this.fetchStates().then(() => {
                        if (this.selectedState) {
                            this.fetchCities().then(() => {
                                this.selectedCity = '{{ old('city_id', $user->city_id) }}';
                            });
                        }
                    });
                },

                fetchStates() {
                    return fetch(`/api/states/${this.countryId}`)
                        .then(res => res.json())
                        .then(data => {
                            this.states = data;
                            this.selectedState = '{{ old('state_id', $user->state_id) }}';
                        });
                },

                fetchCities() {
                    this.cities = [];
                    this.selectedCity = null;
                    if (!this.selectedState) return Promise.resolve();

                    return fetch(`/api/cities/${this.selectedState}`)
                        .then(res => res.json())
                        .then(data => {
                            this.cities = data;
                        });
                }
            }
        }
    </script>
@endsection
