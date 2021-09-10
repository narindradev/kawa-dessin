<script>
    var KTCreateAccount = function() {

        var stepper;
        var form;
        var formSubmitButton;
        var formContinueButton;

        // Variables
        var stepperObj;
        var validations = [];
        var client_type = "particular"

        var type_corporate = document.getElementById('client_type_corporate');
        var type_particular = document.getElementById('client_type_particular');

        type_particular.addEventListener("click", (e) => {
            client_type = type_particular.value
            $("#corport_info").css("display", "none")
        });
        type_corporate.addEventListener("click", (e) => {
            client_type = type_corporate.value
            $("#corport_info").css("display", "")
        });

            // Dropzone.autoDiscover = false;
            // var filesList = new Dropzone("#files", { 
            //     autoProcessQueue: false,
            //     maxFilesize: 1,
            //     paramName: "files",
            //     uploadMultiple :true,
            //     url: url("/home/request/save"),
            //     params: {
            //         _token: getCsrfToken()
            //     },
            //     acceptedFiles: ".jpeg,.jpg,.png,.gif"
            // });
        var initStepper = function() {
            // Initialize Stepper
            stepperObj = new KTStepper(stepper);

            // Stepper change event
            stepperObj.on('kt.stepper.changed', function(stepper) {
                if (stepperObj.getCurrentStepIndex() === 5) {
                    formSubmitButton.classList.remove('d-none');
                    formSubmitButton.classList.add('d-inline-block');
                    formContinueButton.classList.add('d-none');
                } else if (stepperObj.getCurrentStepIndex() === 5) {
                    formSubmitButton.classList.add('d-none');
                    formContinueButton.classList.add('d-none');
                } else {
                    formSubmitButton.classList.remove('d-inline-block');
                    formSubmitButton.classList.remove('d-none');
                    formContinueButton.classList.remove('d-none');
                }
            });

            // Validation before going to next page
            stepperObj.on('kt.stepper.next', function(stepper) {
                console.log('stepper.next');
                // Validate form before change stepper step
                var validator = validations[stepper.getCurrentStepIndex() - 1]; // get validator for currnt step
                var inputs = ["company_name", "company_head_office", "sirdet", "num_tva"]
                console.log("validator")
                console.log(validator)
                inputs.forEach(function(input) {
                    if (client_type == "corporate") {
                        inputValidation = {
                            selector: undefined,
                            validators: {
                                notEmpty: {
                                    message: "{{ trans('lang.required_input') }}"
                                }
                            }
                        }
                        validator.addField(input, inputValidation)
                    } else {
                        if (client_type == "corporate") {
                            validator.removeField(input)
                        }
                    }
                })

                if (validator) {
                    validator.validate().then(function(status) {
                        // console.log('validated!');
                        if (status == 'Valid') {
                            stepper.goNext();
                            KTUtil.scrollTop();
                        } else {

                            Swal.fire({
                                text: "{{ trans('lang.error_global') }}",
                                icon: "error",
                                buttonsStyling: false,
                                confirmButtonText: "{{ trans('lang.ok') }}",
                                customClass: {
                                    confirmButton: "btn btn-light"
                                }
                            }).then(function() {
                                KTUtil.scrollTop();
                            });
                        }
                    });
                } else {
                    stepper.goNext();
                    KTUtil.scrollTop();
                }
            });

            // Prev event
            stepperObj.on('kt.stepper.previous', function(stepper) {
                console.log('stepper.previous');

                stepper.goPrevious();
                KTUtil.scrollTop();
            });
        }

      
        var handleForm = function() {
            formSubmitButton.addEventListener('click', function(e) {
                Swal.fire({
                    text: "{{ trans('lang.messg_rgpd') }}",
                    icon: 'info',
                    showCancelButton: true,
                    confirmButtonText: "{{ trans('lang.continue_and_envoyer') }} <i class='fas fa-paper-plane'></i>",
                    cancelButtonText: "{{ trans('lang.cancel') }}",
                    customClass: {
                        confirmButton: "btn btn-primary confirm-submit-request",
                        cancelButton: "btn btn-secondary"
                    }
                }).then((result) => {

                    if (result.isConfirmed) {

                        e.preventDefault();
                        // Show loading indication
                        
                        formSubmitButton.setAttribute('data-kt-indicator', 'on');
                        formSubmitButton.disabled = true;
                        // filesList.processQueue();
                        // filesList.on("sending", function(file, xhr, formData) {
                        //     // Will send the filesize along with the file as POST data.
                          
                        // });
                        console.log(new FormData(form))
                        axios.post(formSubmitButton.closest('form').getAttribute('action'),new FormData(form))
                            .then(resp => {
                                console.log(resp.data)
                                var icon = resp.data.success ? "success" : "error"
                                Swal.fire({
                                    text: resp.data.message,
                                    icon: icon,
                                    buttonsStyling: false,
                                    confirmButtonText: "Ok",
                                    customClass: {
                                        confirmButton: "btn btn-primary"
                                    }
                                }).then(function(result) {
                                    if (result.isConfirmed) {

                                    }
                                });
                            })


                            .catch(function(error) {
                                let dataMessage = error.response.data.message;
                                let dataErrors = error.response.data.errors;
                                for (const errorsKey in dataErrors) {
                                    if (!dataErrors.hasOwnProperty(errorsKey)) continue;
                                    dataMessage += "\r\n" + dataErrors[errorsKey];
                                }

                                if (error.response) {
                                    Swal.fire({
                                        text: dataMessage,
                                        icon: "error",
                                        buttonsStyling: false,
                                        confirmButtonText: "{{ trans('lang.ok') }}",
                                        customClass: {
                                            confirmButton: "btn btn-primary"
                                        }
                                    });
                                }
                            })
                            .then(function() {
                                formSubmitButton.removeAttribute('data-kt-indicator');
                                formSubmitButton.disabled = false;
                            });

                    } else {
                        return false
                    }
                })
            });

        }


        var initValidation = function() {
            //step 1
            var fields = {}
            var inputs = ["first_name", "last_name", "email", "tel", "address", "tel", "address", "city", "zip"]
            inputs.forEach(function(input) {
                inputValidation = {
                    validators: {
                        notEmpty: {
                            message: "{{ trans('lang.required_input') }}"
                        }
                    }
                }
                if (input == "email") {
                    inputValidation.validators.emailAddress = {
                        message: "{{ trans('lang.required_input_type_email') }}"
                    }
                    inputValidation.validators.remote = {
                        message: "{{ trans('lang.email_already_taked') }}",
                        method: 'POST',
                        url: url('/user/email/exist'),
                    }
                }
                fields[input] = inputValidation
            })

            console.log(fields)
            validations.push(FormValidation.formValidation(
                form, {
                    fields: fields,
                    plugins: {
                        trigger: new FormValidation.plugins.Trigger(),
                        bootstrap: new FormValidation.plugins.Bootstrap5({
                            rowSelector: '.fv-row',
                            eleInvalidClass: '',
                            eleValidClass: ''
                        })
                    }
                }
            ));

            // Step 2

            validations.push(FormValidation.formValidation(
                form, {
                    fields: {
                        'categorie': {
                            validators: {
                                notEmpty: {
                                    message: 'Le choix du projet est necessaire'
                                },

                            }
                        }
                    },
                    plugins: {
                        trigger: new FormValidation.plugins.Trigger(),
                        bootstrap: new FormValidation.plugins.Bootstrap5({
                            rowSelector: '.fv-row',
                            eleInvalidClass: '',
                            eleValidClass: ''
                        })
                    }
                }
            ));

            // Step 3
            var fields_question = {}
            var count_questions = "{{ $questions }}"
            for (let i = 1; i <= parseInt(count_questions); i++) {
                var inputValidation = {
                    validators: {
                        notEmpty: {
                            message: "{{ trans('lang.required_response') }}"
                        }
                    }
                }
                fields_question["question" + i] = inputValidation

            }
            validations.push(FormValidation.formValidation(
                form, {
                    fields: fields_question,
                    plugins: {
                        trigger: new FormValidation.plugins.Trigger(),
                        // Bootstrap Framework Integration
                        bootstrap: new FormValidation.plugins.Bootstrap5({
                            rowSelector: '.fv-row',
                            eleInvalidClass: '',
                            eleValidClass: ''
                        })
                    }
                }
            ));
            // Step 4
            validations.push(FormValidation.formValidation(
                form, {
                    fields: {
                        'accept': {
                            validators: {
                                notEmpty: {
                                    message: "{{ trans('lang.required_input') }}"
                                },

                            }
                        },
                        'checkbox_input': {
                            validators: {
                                notEmpty: {
                                    message: "{{ trans('lang.required_input') }}"
                                },

                            }
                        }
                    },
                    plugins: {
                        trigger: new FormValidation.plugins.Trigger(),
                        // Bootstrap Framework Integration
                        bootstrap: new FormValidation.plugins.Bootstrap5({
                            rowSelector: '.fv-row',
                            eleInvalidClass: '',
                            eleValidClass: ''
                        })
                    }
                }
            ));

        }

        var handleFormSubmit = function() {
            formSubmitButton.addEventListener('click', function(e) {
                e.preventDefault();

                // Validate form

                // Show loading indication
                formSubmitButton.setAttribute('data-kt-indicator', 'on');

                // Disable button to avoid multiple click
                formSubmitButton.disabled = true;

                // Send ajax request
                console.log("sqdqsd" )
                
                axios.post(formSubmitButton.closest('form').getAttribute('action'), data.append("files"))
                    .then(function(response) {
                        console.log(response)
                        Swal.fire({
                            text: "Thank you! You've updated your basic info",
                            icon: "success",
                            buttonsStyling: false,
                            confirmButtonText: "Ok, got it!",
                            customClass: {
                                confirmButton: "btn btn-primary"
                            }
                        }).then(function(result) {
                            if (result.isConfirmed) {}
                        });
                    })
                    .catch(function(error) {
                        let dataMessage = error.response.data.message;
                        let dataErrors = error.response.data.errors;

                        for (const errorsKey in dataErrors) {
                            if (!dataErrors.hasOwnProperty(errorsKey)) continue;
                            dataMessage += "\r\n" + dataErrors[errorsKey];
                        }

                        if (error.response) {
                            Swal.fire({
                                text: dataMessage,
                                icon: "error",
                                buttonsStyling: false,
                                confirmButtonText: "Ok, got it!",
                                customClass: {
                                    confirmButton: "btn btn-primary"
                                }
                            });
                        }
                    })
                    .then(function() {
                        // always executed
                        // Hide loading indication
                        submitButton.removeAttribute('data-kt-indicator');

                        // Enable button
                        submitButton.disabled = false;
                        stepperObj.goNext();
                    });


            });
        }


        return {
            // Public Functions
            init: function() {
                // Elements					
                stepper = document.querySelector('#kt_create_account_stepper');
                form = stepper.querySelector('#request-form');
                formSubmitButton = stepper.querySelector('[data-kt-stepper-action="submit"]');
                formContinueButton = stepper.querySelector('[data-kt-stepper-action="next"]');

                initStepper();
                initValidation();
                handleForm();
            }
        };
    }();

    // On document ready
    KTUtil.onDOMContentLoaded(function() {
        KTCreateAccount.init();
    });
</script>
