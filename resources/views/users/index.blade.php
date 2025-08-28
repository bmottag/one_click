{{-- resources/views/events/index.blade.php --}}
@extends('layouts.app')

@section('breadcrumb')
    <x-breadcrumb 
        :items="[
            ['label' => 'Home', 'url' => route('dashboard')],
            ['label' => 'Clients']
        ]"
    />
@endsection

@section('content')
    <!--begin::Content wrapper-->
    <div class="d-flex flex-column flex-column-fluid">
        <!--begin::Content-->
        <div id="kt_app_content" class="app-content flex-column-fluid">
            <!--begin::Content container-->
            <div id="kt_app_content_container" class="app-container container-fluid">
                <!--begin::Toolbar-->
                <div class="d-flex flex-wrap flex-stack mb-6">
                    <!--begin::Heading-->
                    <h3 class="fw-bold my-2">Clients</h3>
                    <!--end::Heading-->
                </div>
                <!--end::Toolbar-->
                
                @if(!$users->isEmpty())
                    <div class="card card-flush">
                        <!--begin::Card header-->
                        <div class="card-header align-items-center py-5 gap-2 gap-md-5">
                            <!--begin::Card title-->
                            <div class="card-title">
                                <!--begin::Search-->
                                <div class="d-flex align-items-center position-relative my-1">
                                    <!--begin::Svg Icon | path: icons/duotune/general/gen021.svg-->
                                    <span class="svg-icon svg-icon-1 position-absolute ms-4">
                                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <rect opacity="0.5" x="17.0365" y="15.1223" width="8.15546" height="2" rx="1" transform="rotate(45 17.0365 15.1223)" fill="currentColor" />
                                            <path d="M11 19C6.55556 19 3 15.4444 3 11C3 6.55556 6.55556 3 11 3C15.4444 3 19 6.55556 19 11C19 15.4444 15.4444 19 11 19ZM11 5C7.53333 5 5 7.53333 5 11C5 14.4667 7.53333 17 11 17C14.4667 17 17 14.4667 17 11C17 7.53333 14.4667 5 11 5Z" fill="currentColor" />
                                        </svg>
                                    </span>
                                    <!--end::Svg Icon-->
                                    <input type="text" data-kt-ecommerce-product-filter="search" class="form-control form-control-solid w-250px ps-14" placeholder="Search User" />
                                </div>
                                <!--end::Search-->
                            </div>
                            <!--end::Card title-->
                            <!--begin::Card toolbar-->
                            <div class="card-toolbar flex-row-fluid justify-content-end gap-5">
                                <div class="w-100 mw-150px">
                                    <!--begin::Select2-->
                                    <select class="form-select form-select-solid" data-control="select2" data-hide-search="true" data-placeholder="Status" data-kt-ecommerce-product-filter="status">
                                        <option></option>
                                        <option value="all">All</option>
                                        <option value="published">Published</option>
                                        <option value="scheduled">Scheduled</option>
                                        <option value="inactive">Inactive</option>
                                    </select>
                                    <!--end::Select2-->
                                </div>
                            </div>
                            <!--end::Card toolbar-->
                        </div>
                        <!--end::Card header-->
                        <!--begin::Card body-->
                        <div class="card-body pt-0">
                            <!--begin::Table-->
                            <table class="table align-middle table-row-dashed fs-6 gy-5" id="kt_ecommerce_products_table">
                                <!--begin::Table head-->
                                <thead>
                                    <!--begin::Table row-->
                                    <tr class="text-start text-gray-400 fw-bold fs-7 text-uppercase gs-0">
                                        <th class="min-w-150px">Full Name</th>
                                        <th class="text-start min-w-100px">Status</th>
                                        <th class="text-end min-w-100px">Contact Number</th>
                                        <th class="text-start min-w-100px">Province</th>
                                        <th class="text-start min-w-100px">City</th>
                                        <th class="text-center min-w-100px">Role</th>
                                        <th class="text-end min-w-70px">Actions</th>
                                    </tr>
                                    <!--end::Table row-->
                                </thead>
                                <!--end::Table head-->
                                <!--begin::Table body-->
                                <tbody class="fw-semibold text-gray-600">
                                    @foreach($users as $user)
                                        <!--begin::Table row-->
                                        <tr>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <div class="symbol symbol-50px me-3">
                                                        <img src="{{ $user->avatar }}" class="" alt="" />
                                                    </div>
                                                    <div class="d-flex justify-content-start flex-column">
                                                        <a href="#" class="text-gray-800 fw-bold text-hover-primary mb-1 fs-6">{{ $user->name }}</a>
                                                        <span class="text-gray-400 fw-semibold d-block fs-7">{{ $user->email }}</span>
                                                    </div>
                                                </div>
                                            </td>

                                            <td class="text-start pe-0">{{ $user->user_status_label }}</td>

                                            <td class="text-end pe-0">{{ $user->contact_number }}</td>
                                            <td class="text-start pe-0">{{ $user->state->name }}</td>
                                            <td class="text-start pe-0">{{ $user->city->name }}</td>
                                            <td class="text-center pe-0">{!! $user->getRoleBadge() !!}</td>

                                            <!--end::Status=-->
                                            <!--begin::Action=-->
                                            <td class="text-end">
                                                <a href="#" class="btn btn-sm btn-light btn-active-light-primary" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">Actions
                                                <!--begin::Svg Icon | path: icons/duotune/arrows/arr072.svg-->
                                                <span class="svg-icon svg-icon-5 m-0">
                                                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                        <path d="M11.4343 12.7344L7.25 8.55005C6.83579 8.13583 6.16421 8.13584 5.75 8.55005C5.33579 8.96426 5.33579 9.63583 5.75 10.05L11.2929 15.5929C11.6834 15.9835 12.3166 15.9835 12.7071 15.5929L18.25 10.05C18.6642 9.63584 18.6642 8.96426 18.25 8.55005C17.8358 8.13584 17.1642 8.13584 16.75 8.55005L12.5657 12.7344C12.2533 13.0468 11.7467 13.0468 11.4343 12.7344Z" fill="currentColor" />
                                                    </svg>
                                                </span>
                                                <!--end::Svg Icon--></a>
                                                <!--begin::Menu-->
                                                <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-600 menu-state-bg-light-primary fw-semibold fs-7 w-125px py-4" data-kt-menu="true">
                                                    <!--begin::Menu item-->
                                                    <div class="menu-item px-3">
                                                        <a 
                                                            href="#"
                                                            class="menu-link px-3"
                                                            data-item-id="{{ $user->id }}"
                                                            data-bs-toggle="modal"
                                                            data-bs-target="#modal_user"
                                                        >
                                                            Edit
                                                        </a>
                                                    </div>
                                                    <!--end::Menu item-->
                                                    <!--begin::Menu item-->
                                                    <div class="menu-item px-3">
                                                        <a href="#" class="menu-link px-3 btn-delete-event text-danger" data-id="{{ $user->id }}">Delete</a>
                                                    </div>
                                                    <!--end::Menu item-->
                                                </div>
                                                <!--end::Menu-->
                                            </td>
                                            <!--end::Action=-->
                                        </tr>
                                        <!--end::Table row-->
                                    @endforeach
                                </tbody>
                                <!--end::Table body-->
                            </table>
                            <!--end::Table-->
                        </div>
                        <!--end::Card body-->
                    </div>
                @endif
                
            </div>
        </div>
    </div>

    <!--begin::Modals-->
    <!--begin::Modal - USER-->
    <div class="modal fade" id="modal_user" tabindex="-1" aria-hidden="true">
        <!--begin::Modal dialog-->
        <div class="modal-dialog modal-dialog-centered mw-650px">
            <!--begin::Modal content-->
            <div class="modal-content rounded">
                <!--begin::Modal header-->
                <div class="modal-header pb-0 border-0 justify-content-end">
                    <!--begin::Close-->
                    <div class="btn btn-sm btn-icon btn-active-color-primary" data-kt-modal-action-type="close">
                        <!--begin::Svg Icon | path: icons/duotune/arrows/arr061.svg-->
                        <span class="svg-icon svg-icon-1">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <rect opacity="0.5" x="6" y="17.3137" width="16" height="2" rx="1" transform="rotate(-45 6 17.3137)" fill="currentColor" />
                                <rect x="7.41422" y="6" width="16" height="2" rx="1" transform="rotate(45 7.41422 6)" fill="currentColor" />
                            </svg>
                        </span>
                        <!--end::Svg Icon-->
                    </div>
                    <!--end::Close-->
                </div>
                <!--begin::Modal header-->
                <!--begin::Modal body-->
                <div class="modal-body scroll-y px-10 px-lg-15 pt-0 pb-15">
                    <!--begin:Form-->
                    <form id="modal_user_form" class="form" method="POST" action="{{ route('users.update') }}">
                        @csrf
                        <input type="hidden" name="user_id" id="modal_user_id" value="">

                        <!--begin::Heading-->
                        <div class="mb-13 text-center">
                            <!--begin::Title-->
                            <h1 id="modal_user_name" class="mb-3"></h1>
                            <!--end::Title-->
                        </div>
                        <!--end::Heading-->
                        <div class="fv-row mb-8">
                            <label class="d-flex align-items-center fs-6 fw-semibold mb-2">
                                <span>Email</span>
                            </label>
                            <div id="modal_user_email" class="text-muted"></div>
                        </div>
                        <div class="fv-row mb-8">
                            <label class="d-flex align-items-center fs-6 fw-semibold mb-2">
                                <span>Contact Number</span>
                            </label>
                            <div id="modal_contact_number" class="text-muted"></div>
                        </div>

                        <div class="fv-row mb-8">
                            <label class="d-flex align-items-center fs-6 fw-semibold mb-2">
                                <span class="required">Role</span>
                            </label>

                            <select name="role" id="modal_user_role"
                                    class="form-select required @error('role') is-invalid @enderror"
                                    required>
                                <option value="">Select role</option>
                                <option value="registered_user">Registered User</option>
                                <option value="administrator">Administrator</option>
                                <option value="super_admin">Super Admin</option>
                            </select>
                        </div>

                        <!--begin::Actions-->
                        <div class="text-center">
                            <button type="reset" class="btn btn-light me-3" data-kt-modal-action-type="cancel">Cancel</button>
                            <button type="submit" class="btn btn-primary" data-kt-modal-action-type="submit">
                                <span class="indicator-label">Submit</span>
                                <span class="indicator-progress">Please wait...
                                <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                            </button>
                        </div>
                        <!--end::Actions-->
                    </form>
                    <!--end:Form-->
                </div>
                <!--end::Modal body-->
            </div>
            <!--end::Modal content-->
        </div>
        <!--end::Modal dialog-->
    </div>
    <!--end::Modal - New Target-->

    <!--end::Modals-->
@endsection

@section('scripts')
    <script src="{{ asset('js/validations/users.js') }}"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const modal = document.getElementById('modal_user');

            modal.addEventListener('show.bs.modal', function (e) {
                const trigger = e.relatedTarget;
                const itemId = trigger.getAttribute('data-item-id');

                if (!itemId) return;

                // Limpiar contenido mientras carga
                document.getElementById('modal_user_name').textContent = 'Loading...';
                document.getElementById('modal_user_email').textContent = '';

                fetch(`/users/${itemId}/json`)
                    .then(response => {
                        if (!response.ok) throw new Error('User not found');
                        return response.json();
                    })
                    .then(data => {
                        document.getElementById('modal_user_id').value = data.id;
                        document.getElementById('modal_user_name').textContent = data.name;
                        document.getElementById('modal_user_email').textContent = data.email;
                        document.getElementById('modal_contact_number').textContent = data.contact_number;

                        const roleSelect = document.getElementById('modal_user_role');
                        if (roleSelect) {
                            roleSelect.value = data.role;
                        }

                    })
                    .catch(error => {
                        console.error(error);
                        document.getElementById('modal_user_name').textContent = 'Error loading user';
                    });
            });
        });
    </script>
@endsection
