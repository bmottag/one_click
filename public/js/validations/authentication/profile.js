"use strict";

// Class definition
var KTAccountSettingsProfileDetails = function () {
    // Private variables
    var form;
    var submitButton;
    var validation;

    // Private functions
    var handleForm = function () {
        // Init form validation rules. For more info check the FormValidation plugin's official documentation:https://formvalidation.io/
        validation = FormValidation.formValidation(
            form,
            {
                fields: {
                    name: {
                        validators: {
                            notEmpty: {
                                message: 'Full name is required'
                            }
                        }
                    },
                    contact_number: {
                        validators: {
                            notEmpty: {
                                message: 'Phone number is required'
                            },
                            regexp: {
                                regexp: /^[0-9]{7,15}$/,
                                message: 'Enter a valid phone number'
                            }
                        }
                    },
                    state_id: {
                        validators: {
                            notEmpty: {
                                message: 'Please select a province'
                            }
                        }
                    },
                    city_id: {
                        validators: {
                            notEmpty: {
                                message: 'Please select a city'
                            }
                        }
                    },
                    image: {
                        validators: {
                            file: {
                                extension: 'jpeg,jpg,png',
                                type: 'image/jpeg,image/png',
                                maxSize: 2097152, // 2MB en bytes
                                message: 'Please choose a valid image file (jpeg, jpg, png) under 2MB'
                            }
                        }
                    }
                },
				plugins: {
					trigger: new FormValidation.plugins.Trigger(),
                    submitButton: new FormValidation.plugins.SubmitButton(),
					bootstrap: new FormValidation.plugins.Bootstrap5({
                        rowSelector: '.col-lg-8',
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
			if (validation) {
				validation.validate().then(function (status) {
					console.log('validated!');

					if (status == 'Valid') {
						submitButton.setAttribute('data-kt-indicator', 'on');

						// Disable button to avoid multiple click 
						submitButton.disabled = true;

						// Gather form data
						const formData = new FormData(form);

						form.querySelectorAll('.is-invalid').forEach(el => el.classList.remove('is-invalid'));
						form.querySelectorAll('.invalid-feedback').forEach(el => el.remove());

						fetch('/profile', {
							method: 'POST',
							body: formData,
							headers: {
								'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                                'Accept': 'application/json'
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

    }

    // Public methods
    return {
        init: function () {
            form = document.getElementById('kt_account_profile_details_form');

            if (!form) {
                return;
            }

            submitButton = form.querySelector('#kt_account_profile_details_submit');

            handleForm();
        }
    }
}();

// On document ready
KTUtil.onDOMContentLoaded(function() {
    KTAccountSettingsProfileDetails.init();
});
