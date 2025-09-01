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
        // Dropzone config
        Dropzone.autoDiscover = false; // muy importante

        myDropzone = new Dropzone("#kt_modal_new_dropzone", { 
            url: "/restaurants",  
            paramName: "images", 
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
                            formData.append("restaurant_name", form.querySelector('[name="restaurant_name"]').value);
                            formData.append("description", form.querySelector('[name="description"]').value);
                            formData.append("contact_number", form.querySelector('[name="contact_number"]').value);
                            formData.append("address", form.querySelector('[name="address"]').value);
							formData.append("email", form.querySelector('[name="email"]').value);
							formData.append("link", form.querySelector('[name="link"]').value);
							formData.append("facebook", form.querySelector('[name="facebook"]').value);
							formData.append("instagram", form.querySelector('[name="instagram"]').value);
							formData.append("youtube", form.querySelector('[name="youtube"]').value);
                        });

                        myDropzone.processQueue();

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

        myDropzone.on("successmultiple", function(files, response) {
            submitButton.removeAttribute('data-kt-indicator');
            submitButton.disabled = false;

            Swal.fire({
                text: "Item created successfully!",
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
			modalEl = document.querySelector('#kt_modal_new_restaurant');

			if (!modalEl) {
				return;
			}

			modal = new bootstrap.Modal(modalEl);

			form = document.querySelector('#kt_modal_new_restaurant_form');
			submitButton = document.getElementById('kt_modal_new_restaurant_submit');
			cancelButton = document.getElementById('kt_modal_new_restaurant_cancel');

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