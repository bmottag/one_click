"use strict";

// Class definition
var KTAccountSettingsSigninMethods = function () {
    var signInForm;
    var signInMainEl;
    var signInEditEl;
    var passwordMainEl;
    var passwordEditEl;
    var signInChangeEmail;
    var signInCancelEmail;
    var passwordChange;
    var passwordCancel;
    var submitEmailButton;
    var passwordForm;
    var submitPassworndButton;

    var toggleChangeEmail = function () {
        signInMainEl.classList.toggle('d-none');
        signInChangeEmail.classList.toggle('d-none');
        signInEditEl.classList.toggle('d-none');
    }

    var toggleChangePassword = function () {
        passwordMainEl.classList.toggle('d-none');
        passwordChange.classList.toggle('d-none');
        passwordEditEl.classList.toggle('d-none');
    }

    // Private functions
    var initSettings = function () {  
        if (!signInMainEl) {
            return;
        }        

        // toggle UI
        signInChangeEmail.querySelector('button').addEventListener('click', function () {
            toggleChangeEmail();
        });

        signInCancelEmail.addEventListener('click', function () {
            toggleChangeEmail();
        });

        passwordChange.querySelector('button').addEventListener('click', function () {
            toggleChangePassword();
        });

        passwordCancel.addEventListener('click', function () {
            toggleChangePassword();
        });
    }

    var handleChangeEmail = function (e) {
        var validation;        

        if (!signInForm) {
            return;
        }

        validation = FormValidation.formValidation(
            signInForm,
            {
                fields: {
                    email: {
                        validators: {
                            notEmpty: {
                                message: 'Email is required'
                            },
                            emailAddress: {
                                message: 'The value is not a valid email address'
                            }
                        }
                    },

                    password: {
                        validators: {
                            notEmpty: {
                                message: 'Password is required'
                            }
                        }
                    }
                },

                plugins: { //Learn more: https://formvalidation.io/guide/plugins
                    trigger: new FormValidation.plugins.Trigger(),
                    submitEmailButton: new FormValidation.plugins.SubmitButton(),
                    bootstrap: new FormValidation.plugins.Bootstrap5({
                        rowSelector: '.fv-row'
                    })
                }
            }
        );

		// Action buttons
        submitEmailButton.addEventListener('click', function (e) {
            e.preventDefault();
            console.log('click');

			if (validation) {
				validation.validate().then(function (status) {
					console.log('validated!');

					if (status == 'Valid') {
						submitEmailButton.setAttribute('data-kt-indicator', 'on');

						// Disable button to avoid multiple click 
						submitEmailButton.disabled = true;

						// Gather form data
						const formData = new FormData(signInForm);

						signInForm.querySelectorAll('.is-invalid').forEach(el => el.classList.remove('is-invalid'));
						signInForm.querySelectorAll('.invalid-feedback').forEach(el => el.remove());

                        formData.append('_method', 'PUT');

						fetch('/profile/update_email', {
							method: 'POST',
							body: formData,
							headers: {
								'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                                'Accept': 'application/json'
							},
						})
						.then(async response => {
							submitEmailButton.removeAttribute('data-kt-indicator');
							submitEmailButton.disabled = false;

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

									signInForm.reset();
								}
							} else if (response.status === 422) {
								const data = await response.json();
								const errors = data.errors;

								Object.keys(errors).forEach(function(fieldName) {
									// Buscar input por name
									const input = signInForm.querySelector(`[name="${fieldName}"]`);
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
							submitEmailButton.removeAttribute('data-kt-indicator');
							submitEmailButton.disabled = false;

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

    var handleChangePassword = function (e) {
        var validation;

        if (!passwordForm) {
            return;
        }

        validation = FormValidation.formValidation(
            passwordForm,
            {
                fields: {
                    current_password: {
                        validators: {
                            notEmpty: {
                                message: 'Current Password is required'
                            }
                        }
                    },

                    password: {
                        validators: {
                            notEmpty: {
                                message: 'New Password is required'
                            }
                        }
                    },

                    password_confirmation: {
                        validators: {
                            notEmpty: {
                                message: 'Confirm Password is required'
                            },
                            identical: {
                                compare: function() {
                                    return passwordForm.querySelector('[name="password"]').value;
                                },
                                message: 'The password and its confirm are not the same'
                            }
                        }
                    },
                },

                plugins: { //Learn more: https://formvalidation.io/guide/plugins
                    trigger: new FormValidation.plugins.Trigger(),
                    submitButton: new FormValidation.plugins.SubmitButton(),
                    bootstrap: new FormValidation.plugins.Bootstrap5({
                        rowSelector: '.fv-row'
                    })
                }
            }
        );

		// Action buttons
        submitPassworndButton.addEventListener('click', function (e) {
            e.preventDefault();
            console.log('click');

			if (validation) {
				validation.validate().then(function (status) {
					console.log('validated!');

					if (status == 'Valid') {
						submitPassworndButton.setAttribute('data-kt-indicator', 'on');

						// Disable button to avoid multiple click 
						submitPassworndButton.disabled = true;

						// Gather form data
						const formData = new FormData(passwordForm);

						passwordForm.querySelectorAll('.is-invalid').forEach(el => el.classList.remove('is-invalid'));
						passwordForm.querySelectorAll('.invalid-feedback').forEach(el => el.remove());

                        formData.append('_method', 'PUT');

						fetch('/password', {
							method: 'POST',
							body: formData,
							headers: {
								'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                                'Accept': 'application/json'
							},
						})
						.then(async response => {
							submitPassworndButton.removeAttribute('data-kt-indicator');
							submitPassworndButton.disabled = false;

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

									passwordForm.reset();
								}
							} else if (response.status === 422) {
								const data = await response.json();
								const errors = data.errors;

								Object.keys(errors).forEach(function(fieldName) {
									// Buscar input por name
									const input = passwordForm.querySelector(`[name="${fieldName}"]`);
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
							submitPassworndButton.removeAttribute('data-kt-indicator');
							submitPassworndButton.disabled = false;

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
            signInForm = document.getElementById('kt_signin_change_email');
            signInMainEl = document.getElementById('kt_signin_email');
            signInEditEl = document.getElementById('kt_signin_email_edit');
            passwordMainEl = document.getElementById('kt_signin_password');
            passwordEditEl = document.getElementById('kt_signin_password_edit');
            signInChangeEmail = document.getElementById('kt_signin_email_button');
            signInCancelEmail = document.getElementById('kt_signin_cancel');

            passwordForm = document.getElementById('kt_signin_change_password');
            passwordChange = document.getElementById('kt_signin_password_button');
            passwordCancel = document.getElementById('kt_password_cancel');

            submitEmailButton = signInForm.querySelector('#kt_signin_submit');
            submitPassworndButton = passwordForm.querySelector('#kt_password_submit');

            initSettings();
            handleChangeEmail();
            handleChangePassword();
        }
    }
}();

// On document ready
KTUtil.onDOMContentLoaded(function() {
    KTAccountSettingsSigninMethods.init();
});
