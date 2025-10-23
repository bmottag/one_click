"use strict";

// Variables globales
var form;
var submitButton;
var validator; // validator global

// Class definition
var KTSignupGeneral = function() {

    var handleForm  = function() {

        var dueDate = $(form.querySelector('[name="reserve_date"]'));
        dueDate.flatpickr({
            enableTime: true,
            dateFormat: "Y-m-d H:i",
            minDate: "today",
            defaultHour: 7,
            defaultMinute: 0,
            time_24hr: true,
        });

        // Init form validation rules
        validator = FormValidation.formValidation(form, {
            fields: {
                name: {
                    validators: { notEmpty: { message: 'Le prénom et le nom sont obligatoires' } }
                },
                email: {
                    validators: {
                        regexp: {
                            regexp: /^[^\s@]+@[^\s@]+\.[^\s@]+$/,
                            message: "Courriel invalide"
                        },
                        notEmpty: { message: "L'adresse courriel est obligatoire" }
                    }
                },
                contact_number: {
                    validators: { notEmpty: { message: 'Le téléphone est obligatoire' } }
                },
                service: {
                    validators: { notEmpty: { message: 'Le service est obligatoire' } }
                },
                reserve_date: {
                    validators: { notEmpty: { message: "La date et l'heure sont obligatoires" } }
                }
            },
            plugins: {
                trigger: new FormValidation.plugins.Trigger(),
                bootstrap: new FormValidation.plugins.Bootstrap5({
                    rowSelector: '.fv-row',
                    eleInvalidClass: 'is-invalid',
                    eleValidClass: 'is-valid'
                })
            }
        });

        // Handle form submit
        submitButton.addEventListener('click', function (e) {
            e.preventDefault();

            validator.validate().then(function (status) {
                if (status === 'Valid') {
                    submitButton.setAttribute('data-kt-indicator', 'on');
                    submitButton.disabled = true;

                    const formData = new FormData(form);
                    fetch(form.action, {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                            'X-Requested-With': 'XMLHttpRequest',
                            'Accept': 'application/json',
                        },
                        body: formData
                    })
                    .then(response => response.text())
                    .then(text => {
                        let data;
                        try {
                            data = JSON.parse(text);
                        } catch (e) {
                            throw new Error('La réponse du serveur n\'est pas un JSON valide');
                        }
                        if (data.success) {
                            // Mostrar el modal de Stripe
                            var stripeModal = new bootstrap.Modal(document.getElementById('kt_modal_new_card'));
                            stripeModal.show();

                            // Pasar info a Stripe si tu backend devuelve reservation_id
                            const checkoutDiv = document.getElementById('checkout');
                            checkoutDiv.dataset.reservationId = data.reservation_id;
                        } else {
                            const errors = data.errors
                                ? Object.values(data.errors).flat().join('\n')
                                : (data.message || 'Erreur inconnue.');
                            Swal.fire({
                                icon: 'error',
                                title: 'Erreur!',
                                text: errors,
                                confirmButtonText: 'OK',
                            });
                        }
                    })
                    .catch(error => {
                        console.error('Erreur de parsing:', error);
                        Swal.fire({
                            icon: 'error',
                            title: 'Erreur!',
                            text: 'Une erreur est survenue lors du traitement de la réponse.',
                            confirmButtonText: 'OK',
                        });
                    });
                } else {
                    Swal.fire({
                        text: "Veuillez vérifier les champs du formulaire.",
                        icon: "error",
                        buttonsStyling: false,
                        confirmButtonText: "Ok, compris!",
                        customClass: { confirmButton: "btn btn-primary" }
                    });
                }
            });
        });
    }

    return {
        init: function() {
            form = document.querySelector('#kt_sign_up_form');
            submitButton = document.querySelector('#kt_sign_up_submit');
            handleForm();
        }
    };
}();

// On document ready
KTUtil.onDOMContentLoaded(function() {
    KTSignupGeneral.init();

    // === Elements ===
    const serviceSelect = document.getElementById("service");
    const equipeSelect = document.getElementById("equipe");
    const departGroup = document.getElementById("adresse_depart_group");
    const departLabel = document.getElementById("adresse_depart_label");
    const destinationGroup = document.getElementById("adresse_destination_group");
    const div_equipe = document.getElementById("div_equipe");

    const noteDIv = document.getElementById("div_note");
    const noteResidential = document.getElementById("note_residential");
    const noteResidentialPack = document.getElementById("note_residential_pack");
    const noteResidencialLongDistance = document.getElementById("note_residential_and_long_distance");
    const noteLongDistance = document.getElementById("note_long_distance");
    const noteInstallations = document.getElementById("note_installations");
    const piecesDepart = document.getElementById("pieces_depart");
    const installationTypeGroup = document.getElementById("installation_type_group");
    const descriptionGroup = document.getElementById("description_group");
    const descriptionLabelSub = document.getElementById("description_label_sub");

    // Nota personalizada equipe_1
    const noteCustom = document.createElement("div"); 
    noteCustom.classList.add("fs-6", "text-gray-700", "mb-3");
    noteCustom.style.display = "none";
    noteCustom.innerHTML = `
        <div class="fw-semibold"><h4 class="text-gray-900 fw-bold">Service conducteur seulement</h4></div>
        <div>
            Notre conducteur s'occupe de la route et place vos meubles dans le camion. 
            Vous gardez le contrôle de l'emballage, du chargement et du déchargement.
        </div>
    `;
    noteDIv.querySelector(".fw-semibold").appendChild(noteCustom);

    // Opciones dinámicas de équipe
    const equipeOptions = {
        residential: {
            small: [
                { value: "equipe_1", text: "Service conducteur seulement" },
                { value: "equipe_2", text: "Équipe de 2 personnes" },
                { value: "equipe_3", text: "Équipe de 3 personnes" }
            ],
            medium: [
                { value: "equipe_1", text: "Service conducteur seulement" },
                { value: "equipe_3", text: "Équipe de 3 personnes" }
            ],
            large: [
                { value: "equipe_1", text: "Service conducteur seulement" },
                { value: "equipe_3", text: "Équipe de 3 personnes" },
                { value: "equipe_4", text: "2 Équipes de 3 personnes" }
            ]
        },
        residential_pack: {
            small: [
                { value: "equipe_2", text: "Équipe de 2 personnes" },
                { value: "equipe_3", text: "Équipe de 3 personnes" }
            ],
            medium: [
                { value: "equipe_3", text: "Équipe de 3 personnes" }
            ],
            large: [
                { value: "equipe_3", text: "Équipe de 3 personnes" },
                { value: "equipe_4", text: "2 Équipes de 3 personnes" }
            ]
        },
        longue_distance: {
            small: [
                { value: "equipe_1", text: "Service conducteur seulement" },
                { value: "equipe_2", text: "Équipe de 2 personnes" },
                { value: "equipe_3", text: "Équipe de 3 personnes" }
            ],
            medium: [
                { value: "equipe_1", text: "Service conducteur seulement" },
                { value: "equipe_3", text: "Équipe de 3 personnes" }
            ],
            large: [
                { value: "equipe_1", text: "Service conducteur seulement" },
                { value: "equipe_3", text: "Équipe de 3 personnes" },
                { value: "equipe_4", text: "2 Équipes de 3 personnes" }
            ]
        }
    };

    function updateEquipeOptions() {
        const service = serviceSelect.value;
        const pieces = parseInt(piecesDepart.value, 10); 
        equipeSelect.innerHTML = '<option value=""></option>';

        let range = pieces > 5 ? "large" : (pieces > 2 ? "medium" : "small");
        if (equipeOptions[service]) {
            equipeOptions[service][range].forEach(opt => {
                const option = document.createElement("option");
                option.value = opt.value;
                option.textContent = opt.text;
                equipeSelect.appendChild(option);
            });
        }
    }

    // Mapa de campos dinámicos por servicio
    const validationRules = {
        residential: ['no_rue_depart','ville_depart','code_postal_depart','etage_depart','no_rue_destination','ville_destination','code_postal_destination','etage_destination','equipe'],
        residential_pack: ['no_rue_depart','ville_depart','code_postal_depart','etage_depart','no_rue_destination','ville_destination','code_postal_destination','etage_destination','equipe'],
        longue_distance: ['no_rue_depart','ville_depart','code_postal_depart','etage_depart','no_rue_destination','ville_destination','code_postal_destination','etage_destination','equipe'],
        commercial: ['no_rue_depart','ville_depart','code_postal_depart','etage_depart','no_rue_destination','ville_destination','code_postal_destination','etage_destination'],
        installations: ['no_rue_depart','ville_depart','code_postal_depart','etage_depart','installation_type']
    };

    function applyDynamicValidators(service) {
        Object.values(validationRules).flat().forEach(f => {
            const fieldEl = form.querySelector(`[name="${f}"]`);
            if (fieldEl) {
                try { validator.resetField(f, true); } catch(e) {}
            }
        });

        const fieldsToValidate = validationRules[service] || [];
        fieldsToValidate.forEach(f => {
            const fieldEl = form.querySelector(`[name="${f}"]`);
            if (fieldEl && fieldEl.offsetParent !== null && fieldEl.type !== "hidden") { 
                try { 
                    validator.addField(f, { validators: { notEmpty: { message: 'Ce champ est obligatoire' } } }); 
                } catch(e) {}
            }
        });
    }

    function toggleAdresseFields() {
        const value = serviceSelect.value;

        departGroup.style.display = "none";
        destinationGroup.style.display = "none";
        div_equipe.style.display = "none";
        noteDIv.style.display = "none";
        noteResidential.style.display = "none";
        noteResidentialPack.style.display = "none";
        noteResidencialLongDistance.style.display = "none";
        noteLongDistance.style.display = "none";
        noteInstallations.style.display = "none";
        noteCustom.style.display = "none";
        piecesDepart.style.display = "block";
        installationTypeGroup.style.display = "none";
        descriptionGroup.style.display = "none";

        switch(value) {
            case "residential":
                noteDIv.style.display = "block";
                departGroup.style.display = "block";
                destinationGroup.style.display = "block";
                departLabel.textContent = "Adresse de départ";
                noteResidential.style.display = "block";
                noteResidencialLongDistance.style.display = "block";
                div_equipe.style.display = "block";
                descriptionGroup.style.display = "block";
                descriptionLabelSub.innerHTML = `
                    <small>
                        Dites-nous tout ce qui peut faciliter votre déménagement: articles lourds ou particuliers, accès disponibles, horaires d'entrée et de sortie.
                        <br>Chaque détail compte, plus vous partagez d'informations, plus nous pourrons préparer un service adapté, simple et sans stress.
                    </small>
                `;
                equipeSelect.addEventListener("change", () => {
                    noteCustom.style.display = equipeSelect.value === "equipe_1" ? "block" : "none";
                });
                break;
            case "residential_pack":
                noteDIv.style.display = "block";
                departGroup.style.display = "block";
                destinationGroup.style.display = "block";
                departLabel.textContent = "Adresse de départ";
                noteResidential.style.display = "block";
                noteResidentialPack.style.display = "block";
                div_equipe.style.display = "block";
                descriptionGroup.style.display = "block";
                descriptionLabelSub.innerHTML = `
                    <small>
                        Dites-nous tout ce qui peut faciliter votre déménagement: articles lourds ou particuliers, accès disponibles, horaires d'entrée et de sortie.
                        <br>Chaque détail compte, plus vous partagez d'informations, plus nous pourrons préparer un service adapté, simple et sans stress.
                    </small>
                `;
                break;
            case "commercial":
                noteDIv.style.display = "block";
                departGroup.style.display = "block";
                destinationGroup.style.display = "block";
                departLabel.textContent = "Adresse de départ";
                noteResidential.style.display = "block";
                piecesDepart.style.display = "none";
                descriptionGroup.style.display = "block";
                descriptionLabelSub.innerHTML = `
                    <small>
                        Dites-nous tout ce qui peut faciliter votre déménagement: articles lourds ou particuliers, accès disponibles, horaires d'entrée et de sortie.
                        <br>Chaque détail compte, plus vous partagez d'informations, plus nous pourrons préparer un service adapté, simple et sans stress.
                    </small>
                `;
                break;
            case "longue_distance":
                noteDIv.style.display = "block";
                departGroup.style.display = "block";
                destinationGroup.style.display = "block";
                departLabel.textContent = "Adresse de départ";
                noteLongDistance.style.display = "block";
                noteResidencialLongDistance.style.display = "block";
                div_equipe.style.display = "block";
                descriptionGroup.style.display = "block";
                descriptionLabelSub.innerHTML = `
                    <small>
                        Dites-nous tout ce qui peut faciliter votre déménagement: articles lourds ou particuliers, accès disponibles, horaires d'entrée et de sortie.
                        <br>Chaque détail compte, plus vous partagez d'informations, plus nous pourrons préparer un service adapté, simple et sans stress.
                    </small>
                `;
                break;
            case "installations":
                noteDIv.style.display = "block";
                departGroup.style.display = "block";
                destinationGroup.style.display = "none";
                departLabel.textContent = "Adresse";
                noteInstallations.style.display = "block";
                piecesDepart.style.display = "none";
                installationTypeGroup.style.display = "block";
                descriptionGroup.style.display = "block";
                descriptionLabelSub.innerHTML = `
                    <small>
                        Dites-nous tout ce qui peut faciliter l'installation, chaque détail compte, plus vous partagez d'informations, plus nous pourrons préparer un service adapté, simple et sans stress.
                    </small>
                `;
                break;
        }
    }

    function addPiecesValidator() {
        if (piecesDepart.style.display !== "none") {
            try {
                validator.addField('pieces_depart', {
                    validators: { 
                        notEmpty: { message: 'Ce champ est obligatoire' } 
                    }
                });
            } catch(e) {
                // Ignorar si ya existe la validación
            }

            // Revalidar al cambiar el valor
            piecesDepart.addEventListener('change', () => {
                try {
                    validator.revalidateField('pieces_depart');
                } catch(e) {}
            });

        } else {
            try {
                validator.resetField('pieces_depart', true); // eliminar la validación si no está visible
            } catch(e) {}
        }
    }

    // === Listeners ===
    serviceSelect.addEventListener('change', () => {
        toggleAdresseFields();
        updateEquipeOptions();
        applyDynamicValidators(serviceSelect.value);
         addPiecesValidator(); 
    });

    piecesDepart.addEventListener('change', () => {
        updateEquipeOptions();
        //applyDynamicValidators(serviceSelect.value);
         //addPiecesValidator(); 
    });

    // Inicialización
    toggleAdresseFields();
    updateEquipeOptions();
    applyDynamicValidators(serviceSelect.value);


    const priceDiv = document.getElementById("div_price");
    const priceMessage = document.getElementById("price_message");

    // Prices mapping
    const prices = {
        "residential": {
            "equipe_1": 100,
            "equipe_2": 125,
            "equipe_3": 150,
            "equipe_4": 360
        },
        "residential_pack": {
            "equipe_2": 125,
            "equipe_3": 150,
            "equipe_4": 360
        },
        "longue_distance": {
            "equipe_1": 100,
            "equipe_2": 125,
            "equipe_3": 150,
            "equipe_4": 360
        },
        "commercial": {
            "default": "<strong>Équipe de 3 personnes. </strong>Tarif horaire: <strong>180$ / heure.</strong> <br>Minimum de 3 heures de travail. <br>Cette équipe dispose d'un camion de 22 pieds, et le prix final sera ajusté après une évaluation complète de vos besoins."
        },
        "installations": {
            "default": "Le tarif horaire est de <strong>60$ / heure </strong>. <br>Le travail minimum est de 3 heures. <br> Ce tarif correspond à une équipe de deux personnes. Le prix final sera ajusté après avoir bien évalué vos besoins."
        }
    };

    // Friendly French message for selected équipe
    function getPriceMessage(service, equipe) {
        if (!service) return "";

        // If it's commercial or installations without équipe, use default
        if ((service === "commercial" || service === "installations") && !equipe) {
            return prices[service].default;
        }

        const price = prices[service]?.[equipe];
        if (!price) return "Veuillez sélectionner une équipe pour voir le prix.";

        let equipeName = "";
        switch(equipe) {
            case "equipe_1": equipeName = "Service conducteur seulement"; break;
            case "equipe_2": equipeName = "Équipe de 2 personnes"; break;
            case "equipe_3": equipeName = "Équipe de 3 personnes"; break;
            case "equipe_4": equipeName = "2 Équipes de 3 personnes"; break;
        }

        return `Vous avez sélectionné <strong>${equipeName}</strong>. <br>Le tarif horaire est de <strong>${price}$ / heure</strong>. <br>Le travail minimum est de 3 heures.`;
    }

    // Function to update price note
    function updatePriceNote() {
        const service = serviceSelect.value;
        const equipe = equipeSelect.value;

        if (!service) {
            priceDiv.style.display = "none"; // hide if no service selected
            return;
        }

        priceDiv.style.display = "block"; // show the note
        priceMessage.innerHTML = getPriceMessage(service, equipe);
    }

    // === Listeners ===
    serviceSelect.addEventListener("change", updatePriceNote);
    equipeSelect.addEventListener("change", updatePriceNote);

    // Initialize on page load
    updatePriceNote();

});
