"use strict";

// Class definition
var KTModalNewTarget = function () {
	var submitButton;
	var cancelButton;
	var validator;
	var form;
	var modal;
	var modalEl;
	var myDropzone;

	// Init form inputs
	var initForm = function() {
		// Due date. For more info, please visit the official plugin site: https://flatpickr.js.org/
		var dueDate = $(form.querySelector('[name="due_date"]'));
		dueDate.flatpickr({
			enableTime: false,
			dateFormat: "Y-m-d",
		});

        // Dropzone config
        Dropzone.autoDiscover = false; // muy importante

        myDropzone = new Dropzone("#kt_modal_new_dropzone", { 
            url: "/rents",  
            paramName: "rent_images", 
            uploadMultiple: true,
            parallelUploads: 10,
            maxFiles: 10,
            maxFilesize: 5, // MB
            acceptedFiles: "image/*",
            addRemoveLinks: true,
            headers: {
                "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            autoProcessQueue: false 
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

						// Validación de imágenes
						if (!myDropzone || myDropzone.files.length === 0) {
							Swal.fire({
								text: "Please upload at least one image.",
								icon: "error",
								buttonsStyling: false,
								confirmButtonText: "Ok, got it!",
								customClass: { confirmButton: "btn btn-primary" }
							});
							return; // ¡importante! no procesar Dropzone
						}

                        submitButton.setAttribute('data-kt-indicator', 'on');
                        submitButton.disabled = true;

                        // Enviar datos adicionales de Dropzone
                        myDropzone.on("sendingmultiple", function(file, xhr, formData) {
                            formData.append("rent_title", form.querySelector('[name="rent_title"]').value);
                            formData.append("description", form.querySelector('[name="description"]').value);
                            formData.append("contact_number", form.querySelector('[name="contact_number"]').value);
                            formData.append("due_date", form.querySelector('[name="due_date"]').value);
                        });

                        myDropzone.processQueue();

					} else {
						// Show error message.
						Swal.fire({
							text: "Please fill in all required fields and upload at least one image.",
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

        myDropzone.on("successmultiple", function(files, response) {
            submitButton.removeAttribute('data-kt-indicator');
            submitButton.disabled = false;

            Swal.fire({
                text: "Rent created successfully!",
                icon: "success",
                buttonsStyling: false,
                confirmButtonText: "Ok, got it!",
                customClass: { confirmButton: "btn btn-primary" }
            }).then(() => location.reload());
        });

        myDropzone.on("errormultiple", function(files, response) {
            submitButton.removeAttribute('data-kt-indicator');
            submitButton.disabled = false;

            Swal.fire({
                text: "Something went wrong. Please try again.",
                icon: "error",
                buttonsStyling: false,
                confirmButtonText: "Ok, got it!",
                customClass: { confirmButton: "btn btn-primary" }
            });
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

			modalEl.addEventListener('hidden.bs.modal', function () {
				form.reset();                  
				validator.resetForm(true);
				if (myDropzone) {
					myDropzone.removeAllFiles(true);
				}
			});
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