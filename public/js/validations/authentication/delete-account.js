"use strict";

var KTDeleteAccount = function () {
    var form;
    var submitButton;
    var validator;

    var handleForm = function () {
        validator = FormValidation.formValidation(
            form,
            {
                fields: {
                    password: {
                        validators: {
                            notEmpty: {
                                message: 'Password is required'
                            }
                        }
                    }
                },
                plugins: {
                    trigger: new FormValidation.plugins.Trigger(),
                    submitButton: new FormValidation.plugins.SubmitButton(),
                    bootstrap5: new FormValidation.plugins.Bootstrap5({
                        rowSelector: '.fv-row',
                        eleInvalidClass: 'is-invalid',
                        eleValidClass: 'is-valid'
                    })
                }
            }
        );

        submitButton.addEventListener('click', function (e) {
            e.preventDefault();

            validator.validate().then(function (status) {
                if (status === 'Valid') {
                    submitButton.setAttribute('data-kt-indicator', 'on');
                    submitButton.disabled = true;

                    const formData = new FormData(form);
                    formData.append('_method', 'DELETE'); // spoofing para Laravel

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
                            Swal.fire({
                                text: "Your account has been deleted. Goodbye!",
                                icon: "success",
                                buttonsStyling: false,
                                confirmButtonText: "Ok, got it!",
                                customClass: {
                                    confirmButton: "btn btn-primary"
                                }
                            }).then(() => {
                                window.location.href = "/"; // redirigir al home
                            });
                        } else if (response.status === 422) {
                            const data = await response.json();
                            const errors = data.errors;

                            Object.keys(errors).forEach(function(fieldName) {
                                const input = form.querySelector(`[name="${fieldName}"]`);
                                if (input) {
                                    input.classList.add('is-invalid');

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
                                text: "Please check your password and try again.",
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
                    Swal.fire({
                        text: "Please enter your password.",
                        icon: "error",
                        buttonsStyling: false,
                        confirmButtonText: "Ok, got it!",
                        customClass: {
                            confirmButton: "btn btn-primary"
                        }
                    });
                }
            });
        });
    }

    return {
        init: function () {
            form = document.querySelector('#deleteAccountForm');
            submitButton = document.querySelector('#deleteAccountSubmit');

            if (!form) {
                return;
            }

            handleForm();
        }
    };
}();

KTUtil.onDOMContentLoaded(function () {
    KTDeleteAccount.init();
});
