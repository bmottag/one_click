"use strict";

// Class definition
var KTModalNewTarget = function () {
	var submitButton;
	var cancelButton;
	var validator;
	var form;
	var modal;
	var modalEl;

	// Handle form validation and submittion
	var handleForm = function() {
		// Stepper custom navigation

		// Init form validation rules. For more info check the FormValidation plugin's official documentation:https://formvalidation.io/
		validator = FormValidation.formValidation(
			form,
			{
				fields: {
					restaurant_name: {
						validators: {
							notEmpty: {
								message: 'Restaurant name is required'
							}
						}
					},
					description: {
						validators: {
							notEmpty: {
								message: 'Description is required'
							}
						}
					},
					contact_number: {
						validators: {
							notEmpty: {
								message: 'Phone number is required'
							}
						}
					},
					email: {
                        validators: {
                            regexp: {
                                regexp: /^[^\s@]+@[^\s@]+\.[^\s@]+$/,
                                message: 'The value is not a valid email address',
                            },
							notEmpty: {
								message: 'Email address is required'
							}
						}
					},
					address: {
						validators: {
							notEmpty: {
								message: 'Address is required'
							}
						}
					},
					image: {
						validators: {
							notEmpty: {
								message: 'Image is required'
							},
							file: {
								extension: 'jpeg,jpg,png',
								type: 'image/jpeg,image/png',
								maxSize: 2097152, // 2MB en bytes
								message: 'Please choose a valid image file (jpeg, jpg, png) under 2MB'
							}
						}
					},
				},
				plugins: {
					trigger: new FormValidation.plugins.Trigger(),
					bootstrap: new FormValidation.plugins.Bootstrap5({
						rowSelector: '.fv-row',
						eleInvalidClass: 'is-invalid',
						eleValidClass: 'is-valid'
					})
				}
			}
		);

		// Action buttons
		submitButton.addEventListener('click', function (e) {
			e.preventDefault();

			// Validate form before submit
			if (validator) {
				validator.validate().then(function (status) {
					console.log('validated!');

					if (status == 'Valid') {
						submitButton.setAttribute('data-kt-indicator', 'on');

						// Disable button to avoid multiple click 
						submitButton.disabled = true;

						// Gather form data
						const formData = new FormData(form);

						form.querySelectorAll('.is-invalid').forEach(el => el.classList.remove('is-invalid'));
						form.querySelectorAll('.invalid-feedback').forEach(el => el.remove());

						fetch('/restaurants', {
							method: 'POST',
							body: formData,
							headers: {
								'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
							},
						})
						.then(async response => {
							submitButton.removeAttribute('data-kt-indicator');
							submitButton.disabled = false;

							if (response.ok) {
								const data = await response.json();
								if (data.success) {
									Swal.fire({
										text: "Form has been successfully submitted!",
										icon: "success",
										buttonsStyling: false,
										confirmButtonText: "Ok, got it!",
										customClass: {
											confirmButton: "btn btn-primary"
										}
									}).then(function (result) {
										if (result.isConfirmed) {
											location.reload();
										}
									});

									form.reset();
								}
							} else if (response.status === 422) {
								const data = await response.json();
								const errors = data.errors;

								Object.keys(errors).forEach(function(fieldName) {
									// Buscar input por name
									const input = form.querySelector(`[name="${fieldName}"]`);
									if (input) {
										// Agregar clase de error
										input.classList.add('is-invalid');

										// Mostrar mensaje debajo si no existe
										let errorEl = input.nextElementSibling;
										if (!errorEl || !errorEl.classList.contains('invalid-feedback')) {
											errorEl = document.createElement('div');
											errorEl.classList.add('invalid-feedback');
											input.parentNode.appendChild(errorEl);
										}
										errorEl.innerText = errors[fieldName][0];
									}
								});

								Swal.fire({
									text: "Please correct the highlighted errors and try again.",
									icon: "error",
									buttonsStyling: false,
									confirmButtonText: "Ok, got it!",
									customClass: {
										confirmButton: "btn btn-primary"
									}
								});
							} else {
								throw new Error('Unexpected error');
							}
						})
						.catch(error => {
							submitButton.removeAttribute('data-kt-indicator');
							submitButton.disabled = false;

							console.error('AJAX Error:', error);

							Swal.fire({
								text: "Request failed. Please try again.",
								icon: "error",
								buttonsStyling: false,
								confirmButtonText: "Ok, got it!",
								customClass: {
									confirmButton: "btn btn-primary"
								}
							});
						});

					} else {
						// Show error message.
						Swal.fire({
							text: "Sorry, looks like there are some errors detected, please try again.",
							icon: "error",
							buttonsStyling: false,
							confirmButtonText: "Ok, got it!",
							customClass: {
								confirmButton: "btn btn-primary"
							}
						});
					}
				});
			}
		});

		cancelButton.addEventListener('click', function (e) {
			e.preventDefault();

			Swal.fire({
				text: "Are you sure you would like to cancel?",
				icon: "warning",
				showCancelButton: true,
				buttonsStyling: false,
				confirmButtonText: "Yes, cancel it!",
				cancelButtonText: "No, return",
				customClass: {
					confirmButton: "btn btn-primary",
					cancelButton: "btn btn-active-light"
				}
			}).then(function (result) {
				if (result.value) {
					form.reset(); // Reset form	
					modal.hide(); // Hide modal				
				} else if (result.dismiss === 'cancel') {
					Swal.fire({
						text: "Your form has not been cancelled!.",
						icon: "error",
						buttonsStyling: false,
						confirmButtonText: "Ok, got it!",
						customClass: {
							confirmButton: "btn btn-primary",
						}
					});
				}
			});
		});
	}

	return {
		// Public functions
		init: function () {
			// Elements
			modalEl = document.querySelector('#kt_modal_new_restaurant');

			if (!modalEl) {
				return;
			}

			modal = new bootstrap.Modal(modalEl);

			form = document.querySelector('#kt_modal_new_restaurant_form');
			submitButton = document.getElementById('kt_modal_new_restaurant_submit');
			cancelButton = document.getElementById('kt_modal_new_restaurant_cancel');

			handleForm();
		}
	};
}();

// On document ready
KTUtil.onDOMContentLoaded(function () {
	KTModalNewTarget.init();

	// SweetAlert delete handler (¡YA NO está dentro de otro DOMContentLoaded!)
	document.querySelectorAll('.btn-delete').forEach(button => {
		button.addEventListener('click', function (e) {
			e.preventDefault();

			const itemId = this.getAttribute('data-id');

			Swal.fire({
				title: 'Are you sure?',
				text: "This action cannot be undone.",
				icon: 'warning',
				showCancelButton: true,
				confirmButtonText: 'Yes, delete it!',
				cancelButtonText: 'Cancel',
				buttonsStyling: false,
				customClass: {
					confirmButton: 'btn btn-danger',
					cancelButton: 'btn btn-light'
				}
			}).then((result) => {
				if (result.isConfirmed) {
					fetch(`/restaurants/${itemId}`, {
						method: 'DELETE',
						headers: {
							'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
							'Accept': 'application/json'
						}
					})
					.then(response => {
						if (response.ok) {
							Swal.fire({
								title: 'Deleted!',
								text: 'The event has been deleted.',
								icon: 'success',
								confirmButtonText: 'OK',
								buttonsStyling: false,
								customClass: {
									confirmButton: 'btn btn-primary'
								}
							}).then(() => {
								location.reload(); // Refresh page
							});
						} else {
							Swal.fire({
								title: 'Error!',
								text: 'Something went wrong.',
								icon: 'error',
								confirmButtonText: 'OK'
							});
						}
					})
					.catch(error => {
						console.error(error);
						Swal.fire('Error!', 'Server error occurred.', 'error');
					});
				}
			});
		});
	});

});