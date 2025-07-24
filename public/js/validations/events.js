"use strict";

// Class definition
var KTModalNewTarget = function () {
	var submitButton;
	var cancelButton;
	var validator;
	var form;
	var modal;
	var modalEl;

	// Init form inputs
	var initForm = function() {
		// Due date. For more info, please visit the official plugin site: https://flatpickr.js.org/
		var dueDate = $(form.querySelector('[name="event_date"]'));
		dueDate.flatpickr({
			enableTime: true,
			dateFormat: "Y-m-d H:i",
		});

	}

	// Handle form validation and submittion
	var handleForm = function() {
		// Stepper custom navigation

		// Init form validation rules. For more info check the FormValidation plugin's official documentation:https://formvalidation.io/
		validator = FormValidation.formValidation(
			form,
			{
				fields: {
					event_title: {
						validators: {
							notEmpty: {
								message: 'Event title is required'
							}
						}
					},
					event_place: {
						validators: {
							notEmpty: {
								message: 'Event place is required'
							}
						}
					},
					event_description: {
						validators: {
							notEmpty: {
								message: 'Description is required'
							}
						}
					},
					event_date: {
						validators: {
							notEmpty: {
								message: 'Event date is required'
							}
						}
					},
					event_image: {
						validators: {
							notEmpty: {
								message: 'Event image is required'
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

						fetch('/events', {
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
			modalEl = document.querySelector('#kt_modal_new_event');

			if (!modalEl) {
				return;
			}

			modal = new bootstrap.Modal(modalEl);

			form = document.querySelector('#kt_modal_new_event_form');
			submitButton = document.getElementById('kt_modal_new_event_submit');
			cancelButton = document.getElementById('kt_modal_new_event_cancel');

			initForm();
			handleForm();
		}
	};
}();

// On document ready
KTUtil.onDOMContentLoaded(function () {
	KTModalNewTarget.init();
});