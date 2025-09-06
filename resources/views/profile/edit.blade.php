@extends('layouts.app')

@section('breadcrumb')
    <x-breadcrumb 
        :items="[
            ['label' => 'Home', 'url' => route('dashboard')],
            ['label' => 'User'],
			['label' => 'Edit']
        ]"
    />
@endsection

@section('content')
	<div class="d-flex flex-column flex-column-fluid">
		<!--begin::Content-->
		<div id="kt_app_content" class="app-content flex-column-fluid">
			<!--begin::Content container-->
			<div id="kt_app_content_container" class="app-container container-fluid">
				<!--begin::Navbar-->
				<div class="card card-flush mb-9" id="kt_user_profile_panel">
					<!--begin::Hero nav-->
					<div class="card-header rounded-top bgi-size-cover h-200px" style="background-position: 100% 50%; background-image:url('{{ asset('template/assets/media/misc/profile-head-bg.jpg') }}')"></div>
					<!--end::Hero nav-->
					<!--begin::Body-->
					<div class="card-body mt-n19">
						<!--begin::Details-->
						<div class="m-0">
							<!--begin: Pic-->
							<div class="d-flex flex-stack align-items-end pb-4 mt-n19">
								<div class="symbol symbol-125px symbol-lg-150px symbol-fixed position-relative mt-n3">
									<img src="{{ $user->avatar }}" alt="image" class="border border-white border-4" style="border-radius: 20px" />
									<div class="position-absolute translate-middle bottom-0 start-100 ms-n1 mb-9 bg-success rounded-circle h-15px w-15px"></div>
								</div>
							</div>
							<!--end::Pic-->
							<!--begin::Info-->
							<div class="d-flex flex-stack flex-wrap align-items-end">
								<!--begin::User-->
								<div class="d-flex flex-column">
									<!--begin::Name-->
									<div class="d-flex align-items-center mb-2">
										<a href="#" class="text-gray-800 text-hover-primary fs-2 fw-bolder me-1">{{ $user->name }}</a>
										<a href="#"
										class=""
										data-bs-toggle="tooltip"
										data-bs-placement="right"
										title="{{ $user->email_verified_at ? 'Account is verified' : 'Account not verified' }}">
											<!--begin::Svg Icon-->
											<span class="svg-icon svg-icon-1 {{ $user->email_verified_at ? 'svg-icon-primary' : 'svg-icon-default' }}">
												<svg xmlns="http://www.w3.org/2000/svg" width="24px" height="24px" viewBox="0 0 24 24">
													<path d="M10.0813 3.7242C10.8849 2.16438 13.1151 2.16438 13.9187 3.7242V3.7242C14.4016 4.66147 15.4909 5.1127 16.4951 4.79139V4.79139C18.1663 4.25668 19.7433 5.83365 19.2086 7.50485V7.50485C18.8873 8.50905 19.3385 9.59842 20.2758 10.0813V10.0813C21.8356 10.8849 21.8356 13.1151 20.2758 13.9187V13.9187C19.3385 14.4016 18.8873 15.491 19.2086 16.4951V16.4951C19.7433 18.1663 18.1663 19.7433 16.4951 19.2086V19.2086C15.491 18.8873 14.4016 19.3385 13.9187 20.2758V20.2758C13.1151 21.8356 10.8849 21.8356 10.0813 20.2758V20.2758C9.59842 19.3385 8.50905 18.8873 7.50485 19.2086V19.2086C5.83365 19.7433 4.25668 18.1663 4.79139 16.4951V16.4951C5.1127 15.491 4.66147 14.4016 3.7242 13.9187V13.9187C2.16438 13.1151 2.16438 10.8849 3.7242 10.0813V10.0813C4.66147 9.59842 5.1127 8.50905 4.79139 7.50485V7.50485C4.25668 5.83365 5.83365 4.25668 7.50485 4.79139V4.79139C8.50905 5.1127 9.59842 4.66147 10.0813 3.7242V3.7242Z" fill="currentColor" />
													<path d="M14.8563 9.1903C15.0606 8.94984 15.3771 8.9385 15.6175 9.14289C15.858 9.34728 15.8229 9.66433 15.6185 9.9048L11.863 14.6558C11.6554 14.9001 11.2876 14.9258 11.048 14.7128L8.47656 12.4271C8.24068 12.2174 8.21944 11.8563 8.42911 11.6204C8.63877 11.3845 8.99996 11.3633 9.23583 11.5729L11.3706 13.4705L14.8563 9.1903Z" fill="white" />
												</svg>
											</span>
											<!--end::Svg Icon-->
										</a>
									</div>
									<!--end::Name-->
									<!--begin::Text-->
									<span class="fw-bold text-gray-600 fs-6 mb-2 d-block">{!! $user->getRoleBadge() !!}</span>
									<!--end::Text-->
									<!--begin::Info-->
									<div class="d-flex align-items-center flex-wrap fw-semibold fs-7 pe-2">
										<a href="#" class="d-flex align-items-center text-gray-400 text-hover-primary">{{ $user->state->name }}</a>
										<span class="bullet bullet-dot h-5px w-5px bg-gray-400 mx-3"></span>
										<a href="#" class="d-flex align-items-center text-gray-400 text-hover-primary">{{ $user->city->name }}</a>
									</div>
									<!--end::Info-->
								</div>
								<!--end::User-->
							</div>
							<!--end::Info-->
						</div>
						<!--end::Details-->
					</div>
				</div>
				<!--end::Navbar-->
				<!--begin::Nav items-->
				<div id="kt_user_profile_nav" class="rounded bg-gray-200 d-flex flex-stack flex-wrap mb-9 p-2">
					<!--begin::Nav-->
					<ul class="nav flex-wrap border-transparent">
						<!--begin::Nav item-->
						<li class="nav-item my-1">
							<a class="btn btn-sm btn-color-gray-600 bg-state-body btn-active-color-gray-800 fw-bolder fw-bold fs-6 fs-lg-base nav-link px-3 px-lg-4 mx-1" href="{{ route('profile.index') }}">Overview</a>
						</li>
						<!--end::Nav item-->
						<!--begin::Nav item-->
						<li class="nav-item my-1">
							<a class="btn btn-sm btn-color-gray-600 bg-state-body btn-active-color-gray-800 fw-bolder fw-bold fs-6 fs-lg-base nav-link px-3 px-lg-4 mx-1 active" href="{{ route('profile.edit') }}">Settings</a>
						</li>
						<!--end::Nav item-->
						<!--begin::Nav item-->
						<li class="nav-item my-1">
							<a class="btn btn-sm btn-color-gray-600 bg-state-body btn-active-color-gray-800 fw-bolder fw-bold fs-6 fs-lg-base nav-link px-3 px-lg-4 mx-1" href="{{ route('profile.billing') }}">Billing</a>
						</li>
						<!--end::Nav item-->
					</ul>
					<!--end::Nav-->
				</div>
				<!--end::Nav items-->

				<!--begin::Basic info-->
				<div class="card mb-5 mb-xl-10">
					<!--begin::Card header-->
					<div class="card-header border-0 cursor-pointer" role="button" data-bs-toggle="collapse" data-bs-target="#kt_account_profile_details" aria-expanded="true" aria-controls="kt_account_profile_details">
						<!--begin::Card title-->
						<div class="card-title m-0">
							<h3 class="fw-bold m-0">Profile Details</h3>
						</div>
						<!--end::Card title-->
					</div>
					<!--begin::Card header-->
					<!--begin::Content-->
					<div id="kt_account_settings_profile_details" class="collapse show">
						<!--begin::Form-->

						<form id="kt_account_profile_details_form" class="form" enctype="multipart/form-data">
							<!--begin::Card body-->
							<div class="card-body border-top p-9">
								<!--begin::Input group-->
								<div class="row mb-6">
									<!--begin::Label-->
									<label class="col-lg-4 col-form-label fw-semibold fs-6">Avatar</label>
									<!--end::Label-->
									<!--begin::Col-->
									<div class="col-lg-8">
										<!--begin::Image input-->
										<div class="image-input image-input-outline" data-kt-image-input="true" style="background-image: url('assets/media/svg/avatars/blank.svg')">
											<!--begin::Preview existing avatar-->
											<div class="image-input-wrapper w-125px h-125px" style="background-image: url({{ $user->avatar }})"></div>
											<!--end::Preview existing avatar-->
											<!--begin::Label-->
											<label class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow" data-kt-image-input-action="change" data-bs-toggle="tooltip" title="Change avatar">
												<i class="bi bi-pencil-fill fs-7"></i>
												<!--begin::Inputs-->
												<input type="file" name="image" accept=".png, .jpg, .jpeg" />
												<input type="hidden" name="avatar_remove" />
												<!--end::Inputs-->
											</label>
											<!--end::Label-->
											<!--begin::Cancel-->
											<span class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow" data-kt-image-input-action="cancel" data-bs-toggle="tooltip" title="Cancel avatar">
												<i class="bi bi-x fs-2"></i>
											</span>
											<!--end::Cancel-->
											<!--begin::Remove-->
											<span class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow" data-kt-image-input-action="remove" data-bs-toggle="tooltip" title="Remove avatar">
												<i class="bi bi-x fs-2"></i>
											</span>
											<!--end::Remove-->
										</div>
										<!--end::Image input-->
										<!--begin::Hint-->
										<div class="form-text">Allowed file types: png, jpg, jpeg.</div>
										<!--end::Hint-->
									</div>
									<!--end::Col-->
								</div>
								<!--end::Input group-->
								<!--begin::Input group-->
								<div class="row mb-6">
									<!--begin::Label-->
									<label class="col-lg-4 col-form-label required fw-semibold fs-6">Full Name</label>
									<!--end::Label-->
									<!--begin::Col-->
									<div class="col-lg-8 fv-row">
										<input type="text" name="name" class="form-control form-control-lg form-control-solid" placeholder="Full Name" value="{{ old('name', $user->name) }}" autofocus>
									</div>
									<!--end::Col-->
								</div>
								<!--end::Input group-->
								<!--begin::Input group-->
								<div class="row mb-6">
									<!--begin::Label-->
									<label class="col-lg-4 col-form-label fw-semibold fs-6">
										<span class="required">Phone Number</span>
									</label>
									<!--end::Label-->
									<!--begin::Col-->
									<div class="col-lg-8 fv-row">
										<input type="tel" name="contact_number" class="form-control form-control-lg form-control-solid" placeholder="Phone number" value="{{ old('contact_number', $user->contact_number) }}" />
									</div>
									<!--end::Col-->
								</div>
								<!--end::Input group-->

                        		<div x-data="locationData()" x-init="init()">
									<!--begin::Input group-->
									<div class="row mb-6">
										<!--begin::Label-->
										<label class="col-lg-4 col-form-label fw-semibold fs-6">
											<span class="required">Province</span>
										</label>
										<!--end::Label-->
										<!--begin::Col-->
										<div class="col-lg-8 fv-row">
											<select id="state"
													name="state_id"
													x-model="selectedState"
													@change="fetchCities();"
													class="form-select form-select-solid form-select-lg fw-semibold @error('state_id') is-invalid @enderror"
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
										<!--end::Col-->
									</div>
									<!--end::Input group-->

									<!--begin::Input group-->
									<div class="row mb-6">
										<!--begin::Label-->
										<label class="col-lg-4 col-form-label fw-semibold fs-6">
											<span class="required">City</span>
										</label>
										<!--end::Label-->
										<!--begin::Col-->
										<div class="col-lg-8 fv-row">
											<select id="city"
													name="city_id"
													x-model="selectedCity"
													class="form-select form-select-solid form-select-lg fw-semibold @error('city_id') is-invalid @enderror"
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
										<!--end::Col-->
									</div>
									<!--end::Input group-->
                        		</div>

							</div>
							<!--end::Card body-->
							<!--begin::Actions-->
							<div class="card-footer d-flex justify-content-end py-6 px-9">
								<button type="submit" class="btn btn-primary" id="kt_account_profile_details_submit">Save Changes</button>
							</div>
							<!--end::Actions-->
						</form>
						<!--end::Form-->
					</div>
					<!--end::Content-->
				</div>
				<!--end::Basic info-->

				<!--begin::Sign-in Method-->
				<div class="card mb-5 mb-xl-10">
					<!--begin::Card header-->
					<div class="card-header border-0 cursor-pointer" role="button" data-bs-toggle="collapse" data-bs-target="#kt_account_signin_method">
						<div class="card-title m-0">
							<h3 class="fw-bold m-0">Sign-in Method</h3>
						</div>
					</div>
					<!--end::Card header-->
					<!--begin::Content-->
					<div id="kt_account_settings_signin_method" class="collapse show">
						<!--begin::Card body-->
						<div class="card-body border-top p-9">
							<!--begin::Email Address-->
							<div class="d-flex flex-wrap align-items-center">
								<!--begin::Label-->
								<div id="kt_signin_email">
									<div class="fs-6 fw-bold mb-1">Email Address</div>
									<div class="fw-semibold text-gray-600">{{ $user->email }}</div>
								</div>
								<!--end::Label-->
								<!--begin::Edit-->
								<div id="kt_signin_email_edit" class="flex-row-fluid d-none">
									<!--begin::Form-->
									<form id="kt_signin_change_email" class="form" novalidate>
										<div class="row mb-6">
											<div class="col-lg-6 mb-4 mb-lg-0">
												<div class="fv-row mb-0">
													<label for="emailaddress" class="form-label fs-6 fw-bold mb-3">Enter New Email Address</label>
													<input type="email" class="form-control form-control-lg form-control-solid" id="emailaddress" placeholder="Email Address" name="email" value="{{ old('email', $user->email) }}" />
												</div>
											</div>
											<div class="col-lg-6">
												<div class="fv-row mb-0">
													<label for="confirmemailpassword" class="form-label fs-6 fw-bold mb-3">Confirm Password</label>
													<input type="password" class="form-control form-control-lg form-control-solid" name="password" id="confirmemailpassword" />
												</div>
											</div>
										</div>
										<div class="d-flex">
											<button id="kt_signin_submit" type="button" class="btn btn-primary me-2 px-6">Update Email</button>
											<button id="kt_signin_cancel" type="button" class="btn btn-color-gray-400 btn-active-light-primary px-6">Cancel</button>
										</div>
									</form>
									<!--end::Form-->
								</div>
								<!--end::Edit-->
								<!--begin::Action-->
								<div id="kt_signin_email_button" class="ms-auto">
									<button class="btn btn-light btn-active-light-primary">Change Email</button>
								</div>
								<!--end::Action-->
							</div>
							<!--end::Email Address-->
							<!--begin::Separator-->
							<div class="separator separator-dashed my-6"></div>
							<!--end::Separator-->
							<!--begin::Password-->
							<div class="d-flex flex-wrap align-items-center mb-10">
								<!--begin::Label-->
								<div id="kt_signin_password">
									<div class="fs-6 fw-bold mb-1">Password</div>
									<div class="fw-semibold text-gray-600">************</div>
								</div>
								<!--end::Label-->
								<!--begin::Edit-->
								<div id="kt_signin_password_edit" class="flex-row-fluid d-none">
									<!--begin::Form-->
									<form id="kt_signin_change_password" class="form" novalidate>
										<div class="row mb-1">
											<div class="col-lg-4">
												<div class="fv-row mb-0">
													<label for="currentpassword" class="form-label fs-6 fw-bold mb-3">Current Password</label>
													<input type="password" class="form-control form-control-lg form-control-solid" name="current_password" id="current_password" />
												</div>
											</div>
											<div class="col-lg-4">
												<div class="fv-row mb-0">
													<label for="newpassword" class="form-label fs-6 fw-bold mb-3">New Password</label>
													<input type="password" class="form-control form-control-lg form-control-solid" name="password" id="password" />
												</div>
											</div>
											<div class="col-lg-4">
												<div class="fv-row mb-0">
													<label for="confirmpassword" class="form-label fs-6 fw-bold mb-3">Confirm New Password</label>
													<input type="password" class="form-control form-control-lg form-control-solid" name="password_confirmation" id="password_confirmation" />
												</div>
											</div>
										</div>
										<div class="form-text mb-5">Password must be at least 8 character and contain symbols</div>
										<div class="d-flex">
											<button id="kt_password_submit" type="button" class="btn btn-primary me-2 px-6">Update Password</button>
											<button id="kt_password_cancel" type="button" class="btn btn-color-gray-400 btn-active-light-primary px-6">Cancel</button>
										</div>
									</form>
									<!--end::Form-->
								</div>
								<!--end::Edit-->
								<!--begin::Action-->
								<div id="kt_signin_password_button" class="ms-auto">
									<button class="btn btn-light btn-active-light-primary">Reset Password</button>
								</div>
								<!--end::Action-->
							</div>
							<!--end::Password-->
						</div>
						<!--end::Card body-->
					</div>
					<!--end::Content-->
				</div>
				<!--end::Sign-in Method-->

				<!--begin::Deactivate Account-->
				<div class="card">
					<!--begin::Card header-->
					<div class="card-header border-0 cursor-pointer" role="button" data-bs-toggle="collapse" data-bs-target="#kt_account_deactivate" aria-expanded="true" aria-controls="kt_account_deactivate">
						<div class="card-title m-0">
							<h3 class="fw-bold m-0">Deactivate Account</h3>
						</div>
					</div>
					<!--end::Card header-->
					<!--begin::Content-->
					<div id="kt_account_settings_deactivate" class="collapse show">
						<!--begin::Form-->
							<!--begin::Card body-->
							<div class="card-body border-top p-9">
								<!--begin::Notice-->
								<div class="notice d-flex bg-light-warning rounded border-warning border border-dashed mb-9 p-6">
									<!--begin::Icon-->
									<!--begin::Svg Icon | path: icons/duotune/general/gen044.svg-->
									<span class="svg-icon svg-icon-2tx svg-icon-warning me-4">
										<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
											<rect opacity="0.3" x="2" y="2" width="20" height="20" rx="10" fill="currentColor" />
											<rect x="11" y="14" width="7" height="2" rx="1" transform="rotate(-90 11 14)" fill="currentColor" />
											<rect x="11" y="17" width="2" height="2" rx="1" transform="rotate(-90 11 17)" fill="currentColor" />
										</svg>
									</span>
									<!--end::Svg Icon-->
									<!--end::Icon-->
									<!--begin::Wrapper-->
									<div class="d-flex flex-stack flex-grow-1">
										<!--begin::Content-->
										<div class="fw-semibold">
											<h4 class="text-gray-900 fw-bold">You Are Deactivating Your Account</h4>
											<div class="fs-6 text-gray-700">For extra security, this requires you to confirm your email or phone number when you reset yousignr password.
											<br />
											<a class="fw-bold" href="#">Learn more</a></div>
										</div>
										<!--end::Content-->
									</div>
									<!--end::Wrapper-->
								</div>
								<!--end::Notice-->
							</div>
							<!--end::Card body-->
							<!--begin::Card footer-->
							<div class="card-footer d-flex justify-content-end py-6 px-9">
								<button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#deleteAccountModal">
									Delete Account
								</button>
								<!-- Modal -->
								<div class="modal fade" id="deleteAccountModal" tabindex="-1" aria-hidden="true">
									<div class="modal-dialog modal-dialog-centered">
										<div class="modal-content">
											<form id="deleteAccountForm" class="form">

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
													<button type="submit" id="deleteAccountSubmit" class="btn btn-danger">Delete Account</button>
												</div>
											</form>
										</div>
									</div>
								</div> <!-- end modal -->
							</div>
							<!--end::Card footer-->
					</div>
					<!--end::Content-->
				</div>
				<!--end::Deactivate Account-->

			</div>
			<!--end::Content container-->
		</div>
		<!--end::Content-->
	</div>
@endsection

@section('scripts')
	<script src="{{ asset('js/validations/authentication/profile.js') }}"></script>
	<script src="{{ asset('js/validations/authentication/signin-methods.js') }}"></script>
	<script src="{{ asset('js/validations/authentication/delete-account.js') }}"></script>

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
