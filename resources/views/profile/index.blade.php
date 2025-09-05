@extends('layouts.app')

@section('breadcrumb')
    <x-breadcrumb 
        :items="[
            ['label' => 'Home', 'url' => route('dashboard')],
            ['label' => 'User'],
			['label' => 'Profile']
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
							<a class="btn btn-sm btn-color-gray-600 bg-state-body btn-active-color-gray-800 fw-bolder fw-bold fs-6 fs-lg-base nav-link px-3 px-lg-4 mx-1 active" href="{{ route('profile.index') }}">Overview</a>
						</li>
						<!--end::Nav item-->
						<!--begin::Nav item-->
						<li class="nav-item my-1">
							<a class="btn btn-sm btn-color-gray-600 bg-state-body btn-active-color-gray-800 fw-bolder fw-bold fs-6 fs-lg-base nav-link px-3 px-lg-4 mx-1" href="{{ route('profile.edit') }}">Settings</a>
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
				<!--begin::details View-->
				<div class="card mb-5 mb-xl-10" id="kt_profile_details_view">
					<!--begin::Card header-->
					<div class="card-header cursor-pointer">
						<!--begin::Card title-->
						<div class="card-title m-0">
							<h3 class="fw-bold m-0">Profile Details</h3>
						</div>
						<!--end::Card title-->
						<!--begin::Action-->
						<a href="../../demo8/dist/account/settings.html" class="btn btn-sm btn-primary align-self-center">Edit Profile</a>
						<!--end::Action-->
					</div>
					<!--begin::Card header-->
					<!--begin::Card body-->
					<div class="card-body p-9">
						<!--begin::Row-->
						<div class="row mb-7">
							<!--begin::Label-->
							<label class="col-lg-4 fw-semibold text-muted">Full Name</label>
							<!--end::Label-->
							<!--begin::Col-->
							<div class="col-lg-8">
								<span class="fw-bold fs-6 text-gray-800">{{ $user->name }}</span>
							</div>
							<!--end::Col-->
						</div>
						<!--end::Row-->
						<!--begin::Input group-->
						<div class="row mb-7">
							<!--begin::Label-->
							<label class="col-lg-4 fw-semibold text-muted">Email</label>
							<!--end::Label-->
							<!--begin::Col-->
							<div class="col-lg-8 d-flex align-items-center">
								<span class="fw-bold fs-6 text-gray-800 me-2">{{ $user->email }}</span>
								<span class="badge {{ $user->email_verified_at ? 'badge-success' : 'badge-danger' }}">{{ $user->email_verified_at ? 'Account is verified' : 'Account not verified' }}</span>
							</div>
							<!--end::Col-->
						</div>
						<!--end::Input group-->
						<!--begin::Input group-->
						<div class="row mb-7">
							<!--begin::Label-->
							<label class="col-lg-4 fw-semibold text-muted">Contact Phone
							<i class="fas fa-exclamation-circle ms-1 fs-7" data-bs-toggle="tooltip" title="Phone number must be active"></i></label>
							<!--end::Label-->
							<!--begin::Col-->
							<div class="col-lg-8 fv-row">
								<span class="fw-semibold text-gray-800 fs-6">{{ $user->contact_number }}</span>
							</div>
							<!--end::Col-->
						</div>
						<!--end::Input group-->
						<!--begin::Input group-->
						<div class="row mb-7">
							<!--begin::Label-->
							<label class="col-lg-4 fw-semibold text-muted">Country</label>
							<!--end::Label-->
							<!--begin::Col-->
							<div class="col-lg-8">
								<span class="fw-bold fs-6 text-gray-800">Canada</span>
							</div>
							<!--end::Col-->
						</div>
						<!--end::Input group-->
						<!--begin::Input group-->
						<div class="row mb-7">
							<!--begin::Label-->
							<label class="col-lg-4 fw-semibold text-muted">Province</label>
							<!--end::Label-->
							<!--begin::Col-->
							<div class="col-lg-8">
								<span class="fw-bold fs-6 text-gray-800">{{ $user->state->name }}</span>
							</div>
							<!--end::Col-->
						</div>
						<!--end::Input group-->
						<!--begin::Input group-->
						<div class="row mb-10">
							<!--begin::Label-->
							<label class="col-lg-4 fw-semibold text-muted">City</label>
							<!--begin::Label-->
							<!--begin::Label-->
							<div class="col-lg-8">
								<span class="fw-semibold fs-6 text-gray-800">{{ $user->city->name }}</span>
							</div>
							<!--begin::Label-->
						</div>
						<!--end::Input group-->
						<!--begin::Notice-->
						<div class="notice d-flex bg-light-warning rounded border-warning border border-dashed p-6">
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
									<h4 class="text-gray-900 fw-bold">We need your attention!</h4>
									<div class="fs-6 text-gray-700">Your payment was declined. To start using tools, please
									<a class="fw-bold" href="../../demo8/dist/account/billing.html">Add Payment Method</a>.</div>
								</div>
								<!--end::Content-->
							</div>
							<!--end::Wrapper-->
						</div>
						<!--end::Notice-->
					</div>
					<!--end::Card body-->
				</div>
				<!--end::details View-->


			</div>
			<!--end::Content container-->
		</div>
		<!--end::Content-->
	</div>
@endsection