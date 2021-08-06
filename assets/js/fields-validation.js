/**
 * @param {object} options
 */
function fieldsValidation(options = {}) {

    /**
     * @var {Array}
     */
    let _fields = options.fields;

    /**
     * @var {HTMLElement}
     */
    let _form = options.form;

    /**
     * @var {HTMLElement}
     */
    let _submitButton = options.submitButton;

    /**
     * @var {String}
     */
    const HAS_FIELD_VALIDATION_ERROR_CLASS = 'has-field-validation-error';

    /**
     * @var {String}
     */
    const FIELD_VALIDATION_ERROR_MESSAGE_CLASS = 'field-validation-error-message';

    /**
     * @var {String}
     */
    const FIELD_VALIDATION_ERROR_CONTAINER_CLASS = 'field-validation-error-container';

    /**
     * @var {String}
     */
    const VALIDATOR_FOR_ATTR_NAME = 'validator-for';

    /**
     * Make object with validation result.
     * @param {Boolean} valid 
     * @param {String} error 
     * @returns {object}
     */
    const makeResult = function (valid = true, error = '') {
        return { valid: valid, error: error }
    }

    /**
     * @var {Array}
     */
    const VALIDATORS = [
        {
            type: 'slug',
            handler: function (input) {
                let valid = true, error = '', value = input.value;
                if (value && (/[ `!@#$%^&*()+=\[\]{};':"\\|,.<>\/?~]/g.test(value) || value !== value.toLowerCase())) {
                    valid = false;
                    error = 'Value is invalid.';
                }
                return makeResult(valid, error);
            }
        },
        {
            type: 'required',
            handler: function (input) {
                let valid = true, error = '';
                if (!input.value.trim()) {
                    valid = false;
                    error = "Field is required.";
                }
                return makeResult(valid, error);
            }
        },
        {
            type: 'no-ending-slash',
            handler: function (input) {
                let valid = true, error = '', value = input.value;
                if (value && /[^\/]$|^$/g.test(value) === false) {
                    valid = false;
                    error = 'Ending slash is not allowed.';
                }
                return makeResult(valid, error);
            }
        }
    ];

    /**
     * Clear errors for input.
     * @param {HTMLElement} input 
     */
    const clear = function (input) {
        let errorContainer = findErrorContainerForInput(input);
        input.classList.remove(HAS_FIELD_VALIDATION_ERROR_CLASS);
        (errorContainer) && errorContainer.remove();
    }

    /**
     * Find existing error container for input.
     * @param {HTMLElement} input 
     * @returns {HTMLElement|null}
     */
    const findErrorContainerForInput = function (input) {
        return document.querySelectorAll('[' + VALIDATOR_FOR_ATTR_NAME + '="' + input.name + '"]')[0] || null;
    }

    /**
     * Handle error notification.
     * @param {HTMLElement} input 
     * @param {String} error 
     */
    const notify = function (input, error = '') {
        if (error) {
            let container = findErrorContainerForInput(input);
            let errorMessage;
            if (container) {
                errorMessage = container.querySelector('.' + FIELD_VALIDATION_ERROR_MESSAGE_CLASS);
            } else {
                container = document.createElement('div');
                container.classList.add(FIELD_VALIDATION_ERROR_CONTAINER_CLASS);
                errorMessage = document.createElement('div');
                errorMessage.classList.add(FIELD_VALIDATION_ERROR_MESSAGE_CLASS);
                errorMessage.append(error);
                input.after(container);
                container.append(errorMessage);
                container.setAttribute(VALIDATOR_FOR_ATTR_NAME, input.name);
                container.style.width = input.offsetWidth + 'px';
            }
            errorMessage.innerHTML = error;
        }
        input.classList.add(HAS_FIELD_VALIDATION_ERROR_CLASS);
    }

    /**
     * Find validator by type.
     * @param {String} type 
     * @returns {object|undefined}
     */
    const findValidator = function (type = '') {
        let validator;
        VALIDATORS.forEach(function (validator_) {
            if (validator_.type === type) {
                validator = validator_;
                return false;
            }
        });
        return validator;
    }

    /**
     * Perform validation for field.
     * @param {HTMLElement} input 
     * @param {Array} validators 
     * @returns {object}
     */
    const validate = function (input, validators) {
        let valid = true, error = '';
        validators.forEach(function (validatorType) {
            let result = findValidator(validatorType).handler(input);
            if (result.valid === false) {
                error = result.error;
                valid = false;
                return false;
            }
        });
        (valid === false) ? notify(input, error) : clear(input);
        return { valid: valid, error: error };
    }

    let timeout = null;

    /**
     * Initialize validation for element.
     * @param {HTMLElement} input 
     * @param {Array} validators 
     */
    const initializeField = function (input, validators = []) {
        input.addEventListener('input', function (event) {
            validate(input, validators);
        });
    }

    /**
     * Handle state of submit button.
     * @param {HTMLElement} submitButton 
     * @param {Array} fields 
     */
    const handleSubmitButtonState = function (submitButton, fields = []) {
        let timeout = null;
        const callback = function (event) {
            if (timeout) {
                clearTimeout(timeout);
                timeout = null;
            }
            if (timeout === null) {
                timeout = setTimeout(function () {
                    submitButton.disabled = validateAll(fields).valid === false;
                }, 100);
            }
        }
        fields.forEach(function (field) {
            field.input.addEventListener('input', callback);
        });
    }

    const validateAll = function (fields = []) {
        let valid = true;
        fields.forEach(function (field) {
            if (validate(field.input, field.validators).valid === false) {
                valid = false;
                return false;
            }
        });
        return { valid: valid }
    }

    /**
     * Handler for form onsubmit event.
     * @param {Event} event
     * @param {Array} fields
     */
    const onFormSubmitHandler = function (event, fields = []) {
        let valid = true;
        fields.forEach(function (field) {
            if (validate(field.input, field.validators).valid === false) {
                valid = false;
                return false;
            }
        });
        (valid === false) && event.preventDefault();
    }

    /**
     * Set up validation.
     * @param {HTMLElement} form 
     * @param {Array} fields 
     * @param {HTMLElement} submitButton
     */
    const setup = function (form, fields = [], submitButton) {
        fields.forEach(function (item) { initializeField(item.input, item.validators); });
        handleSubmitButtonState(submitButton, fields);
        form.onsubmit = function (event) { onFormSubmitHandler(event, fields); };
    }

    setup(_form, _fields, _submitButton);
}