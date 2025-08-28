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
        // Date picker
        var dueDate = $(form.querySelector('[name="event_date"]'));
        dueDate.flatpickr({
            enableTime: true,
            dateFormat: "Y-m-d H:i",
        });

        // Dropzone config
        Dropzone.autoDiscover = false; // muy importante

        myDropzone = new Dropzone("#kt_modal_new_event_dropzone", { 
            url: "/events",  
            paramName: "event_images", 
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
    };

    // Handle form validation and submission
    var handleForm = function() {
        validator = FormValidation.formValidation(
            form,
            {
                fields: {
                    event_title: {
                        validators: {
                            notEmpty: { message: 'Event title is required' }
                        }
                    },
                    event_place: {
                        validators: {
                            notEmpty: { message: 'Event place is required' }
                        }
                    },
                    event_description: {
                        validators: {
                            notEmpty: { message: 'Description is required' }
                        }
                    },
                    event_date: {
                        validators: {
                            notEmpty: { message: 'Event date is required' }
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

        submitButton.addEventListener('click', function(e) {
            e.preventDefault();

            if (validator) {
                validator.validate().then(function(status) {
                    if (status === 'Valid') {
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
                            formData.append("event_title", form.querySelector('[name="event_title"]').value);
                            formData.append("event_place", form.querySelector('[name="event_place"]').value);
                            formData.append("event_description", form.querySelector('[name="event_description"]').value);
                            formData.append("event_date", form.querySelector('[name="event_date"]').value);
                            formData.append("link", form.querySelector('[name="link"]').value);
                            formData.append("instagram", form.querySelector('[name="instagram"]').value);
                        });

                        myDropzone.processQueue();
                    } else {
                        // Mostrar modal si hay errores
                        Swal.fire({
                            text: "Please fill in all required fields and upload at least one image.",
                            icon: "error",
                            buttonsStyling: false,
                            confirmButtonText: "Ok, got it!",
                            customClass: { confirmButton: "btn btn-primary" }
                        });
                    }
                });
            }
        });

        myDropzone.on("successmultiple", function(files, response) {
            submitButton.removeAttribute('data-kt-indicator');
            submitButton.disabled = false;

            Swal.fire({
                text: "Event created successfully!",
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

        cancelButton.addEventListener('click', function(e) {
            e.preventDefault();

            Swal.fire({
                text: "Are you sure you would like to cancel?",
                icon: "warning",
                showCancelButton: true,
                buttonsStyling: false,
                confirmButtonText: "Yes, cancel it!",
                cancelButtonText: "No, return",
                customClass: { confirmButton: "btn btn-primary", cancelButton: "btn btn-active-light" }
            }).then(function(result) {
                if (result.value) {
                    form.reset(); 
                    modal.hide(); 
                } else if (result.dismiss === 'cancel') {
                    Swal.fire({
                        text: "Your form has not been cancelled!.",
                        icon: "error",
                        buttonsStyling: false,
                        confirmButtonText: "Ok, got it!",
                        customClass: { confirmButton: "btn btn-primary" }
                    });
                }
            });
        });
    }

    return {
        init: function() {
            modalEl = document.querySelector('#kt_modal_new_event');
            if (!modalEl) return;

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

    document.querySelectorAll('.btn-delete-event').forEach(button => {
        button.addEventListener('click', function(e) {
            e.preventDefault();
            const eventId = this.getAttribute('data-id');

            Swal.fire({
                title: 'Are you sure?',
                text: "This action cannot be undone.",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Yes, delete it!',
                cancelButtonText: 'Cancel',
                buttonsStyling: false,
                customClass: { confirmButton: 'btn btn-danger', cancelButton: 'btn btn-light' }
            }).then((result) => {
                if (result.isConfirmed) {
                    fetch(`/events/${eventId}`, {
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
                                customClass: { confirmButton: 'btn btn-primary' }
                            }).then(() => location.reload());
                        } else {
                            Swal.fire({ title: 'Error!', text: 'Something went wrong.', icon: 'error', confirmButtonText: 'OK' });
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
