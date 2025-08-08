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
		var dueDate = $(form.querySelector('[name="due_date"]'));
		dueDate.flatpickr({
			enableTime: false,
			dateFormat: "Y-m-d",
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
					rent_title: {
						validators: {
							notEmpty: {
								message: 'Rent title is required'
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
								message: 'Contact Number is required'
							}
						}
					},
					due_date: {
						validators: {
							notEmpty: {
								message: 'Due date is required'
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

						fetch('/rents', {
							method: 'POST',
							body: formData,
							headers: {
								'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
							},
						})
						.then(response => response.json())
						.then(data => {
							submitButton.removeAttribute('data-kt-indicator');
							submitButton.disabled = false;

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

								// Limpiar formulario
								form.reset();
							} else {
								Swal.fire({
									text: data.message || "Something went wrong.",
									icon: "error",
									buttonsStyling: false,
									confirmButtonText: "Ok, got it!",
									customClass: {
										confirmButton: "btn btn-primary"
									}
								});
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
			modalEl = document.querySelector('#modal_new_rent');

			if (!modalEl) {
				return;
			}

			modal = new bootstrap.Modal(modalEl);

			form = document.querySelector('#modal_new_rent_form');
			submitButton = document.getElementById('modal_new_rent_submit');
			cancelButton = document.getElementById('modal_new_rent_cancel');

			initForm();
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
					fetch(`/rents/${itemId}`, {
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