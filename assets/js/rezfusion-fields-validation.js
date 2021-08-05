/**
 * Field Validation Data Object.
 * @typedef {Object} FieldValidationDataObject
 * @property {HTMLElement} input - Input element.
 * @property {Array.String} validators - List of validators types.
 * @property {HTMLElement} errorContainer - Optional parameter; container for error messages.
 */

/**
 * Handles validation for set of fields.
 * 
 * @param {Object} options {fields: Array.FieldValidationDataObject, form: HTMLElement, submitButton: HTMLElement}
 * 
 * @returns {Object}
 */
function rezfusionFieldsValidation(options = {}) {

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
    const HAS_FIELD_VALIDATION_ERROR_CLASS = 'rezfusion-fields-validation__has-field-validation-error';

    /**
     * @var {String}
     */
    const FIELD_VALIDATION_ERROR_MESSAGE_CLASS = 'rezfusion-fields-validation__field-validation-error-message';

    /**
     * @var {String}
     */
    const VALIDATOR_FOR_ATTR_NAME = 'rezfusion-validator-for';

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
        }
    ];

    /**
     * Clear errors for input.
     * @param {FieldValidationDataObject} item
     */
    const clear = function (item) {
        let errorContainer = findErrorContainerForInput(item);
        item.input.classList.remove(HAS_FIELD_VALIDATION_ERROR_CLASS);
        if (errorContainer) {
            errorContainer.innerHTML = '';
            errorContainer.style.display = 'none';
        }
    }

    /**
     * Find existing error container for input.
     * @param {FieldValidationDataObject} item
     */
    const findErrorContainerForInput = function (item) {
        if (typeof item.errorContainer !== 'undefined') {
            return item.errorContainer;
        }
        let input = item.input,
            errorContainer = document.querySelector('[' + VALIDATOR_FOR_ATTR_NAME + '="' + input.name + '"]') || null;
        if (!errorContainer) {
            errorContainer = document.createElement('div');
            errorContainer.classList.add(FIELD_VALIDATION_ERROR_MESSAGE_CLASS);
            errorContainer.setAttribute(VALIDATOR_FOR_ATTR_NAME, input.name);
            errorContainer.style.display = 'none';
            input.after(errorContainer);
        }
        return errorContainer;
    }

    /**
     * Handle error notification.
     * @param {FieldValidationDataObject} item
     * @param {String} error 
     */
    const notify = function (item, error = '') {
        let input = item.input, errorContainer;
        if (error && (errorContainer = findErrorContainerForInput(item))) {
            errorContainer.innerHTML = error;
            errorContainer.style.display = '';
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
     * @param {FieldValidationDataObject} item
     * @returns {object}
     */
    const validate = function (item) {
        let valid = true, error = '';
        item.validators.forEach(function (validatorType) {
            let result = findValidator(validatorType).handler(item.input);
            if (result.valid === false) {
                error = result.error;
                valid = false;
                return false;
            }
        });
        (valid === false) ? notify(item, error) : clear(item);
        return { valid: valid, error: error };
    }

    /**
     * Initialize validation for element.
     * @param {FieldValidationDataObject} item
     */
    const initializeField = function (item) {
        item.input.addEventListener('input', function (event) {
            validate(item);
        });
    }

    /**
     * Handler for form onsubmit event.
     * @param {Event} event
     * @param {Array} fields
     * @param {Event} onsubmit
     */
    const onFormSubmitHandler = function (event, fields = [], onsubmit) {
        let valid = true;
        fields.forEach(function (field) {
            if (validate(field).valid === false) {
                valid = false;
                return false;
            }
        });
        if (valid === false) {
            event.preventDefault();
            return;
        }
        (typeof onsubmit === 'function') && onsubmit(event);
    }

    /**
     * Set up validation.
     * @param {HTMLElement} form 
     * @param {Array} fields 
     * @param {HTMLElement} submitButton
     */
    const setup = function (form, fields = [], submitButton) {
        fields.forEach(function (item) { initializeField(item); });
        const originalSubmit = form.onsubmit;
        form.onsubmit = function (event) { onFormSubmitHandler(event, fields, originalSubmit); };
    }

    /**
     * Reset validation.
     */
    const _reset = function () {
        _fields.forEach(function (item) {
            clear(item);
        });
    }

    setup(_form, _fields, _submitButton);

    return {
        reset: _reset
    };
}