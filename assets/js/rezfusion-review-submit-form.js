/**
 * Handles initialization of *Review Submit* form.
 * @param {Object} options {form: HTMLElement, submitButton: HTMLElement, messageContainer: HTMLElement, postId: Number}
 * @returns {Object}
 */
function rezfusionReviewSubmitForm(options = {}) {

  /**
   * @var {HTMLElement}
   */
  const _form = options.form;

  /**
   * @var {HTMLElement}
   */
  const _submitButton = options.submitButton;

  /**
   * @var {HTMLElement}
   */
  const _messageContainer = options.messageContainer;

  /**
   * @var {Number}
   */
  const _postId = options.postId;

  /**
   * @var {rezfusionFieldsValidation}
   */
  let _fieldsValidation;

  /**
   * @var {Object}
   */
  let _fieldToNameMap = {
    guestName: 'review-guest-name',
    rating: 'review-rating',
    stayDate: 'review-stay-date',
    title: 'review-title',
    review: 'review-content'
  };

  /**
   * Send request with review data.
   * @param {Object} review 
   */
  const _submitReview = function (review) {
    var xhr = new XMLHttpRequest();
    xhr.open("POST", '/wp-json/rezfusion/submit-review', true);
    xhr.setRequestHeader('Content-Type', 'application/json');
    xhr.send(JSON.stringify(review));
    xhr.onreadystatechange = function () {
      if (xhr.readyState === 4) {
        if (xhr.status === 200) {
          _hideForm();
          _showMessage("Thank you for your review!");
        } else {
          let json = JSON.parse(xhr.responseText);
          if (json.error) {
            _showMessage(json.error);
          }
        }
      }
    }
  }

  /**
   * Retrieve review data from form.
   * @param {HTMLElement} form 
   * @param {Object} fieldToNameMap 
   * @returns {Object}
   */
  const _makeReviewDataTransferObject = function (form, fieldToNameMap) {
    let review = {
      postId: _postId
    };
    for (field in fieldToNameMap) {
      let value = form.querySelector('[name="' + fieldToNameMap[field] + '"]').value;
      if (field === 'rating')
        value = parseInt(value);
      review[field] = value;
    }
    return review;
  }

  /**
   * Handle *onsubmit* event.
   * @param {Object} event onsubmit event
   */
  const onFormSubmit = function (event) {
    event.preventDefault();
    let review = _makeReviewDataTransferObject(_form, _fieldToNameMap);
    _submitReview(review);
  }

  /**
   * Initialize component.
   * @param {HTMLElement} form 
   * @param {HTMLElement} submitButton 
   */
  const _init = function (form, submitButton) {
    form.onsubmit = onFormSubmit;
    _fieldsValidation = _initValidation(form, submitButton, [
      { input: document.getElementsByName('review-guest-name')[0], validators: ['required'] },
      { input: document.getElementsByName('review-rating')[0], validators: ['required'] },
      { input: document.getElementsByName('review-stay-date')[0], validators: ['required'] },
      { input: document.getElementsByName('review-title')[0], validators: ['required'] },
      { input: document.getElementsByName('review-content')[0], validators: ['required'] }
    ]);
    _reset();
  }

  /**
   * Get array of all fields.
   * @returns {Array.HTMLElement}
   */
  const getAllFields = function () {
    let fields = [];
    for (field in _fieldToNameMap) {
      fields.push(document.getElementsByName(_fieldToNameMap[field])[0]);
    }
    return fields;
  }

  /**
   * Show user interface message.
   * @param {String} message 
   */
  const _showMessage = function (message = '') {
    _messageContainer.innerHTML = message;
  }

  /**
   * Reset form.
   */
  const _reset = function () {
    getAllFields().forEach(function (field) {
      field.value = '';
      field.dispatchEvent(new Event('input'));
    });
    _messageContainer.innerHTML = '';
    _fieldsValidation.reset();
  }

  /**
   * Initialize validation.
   * @param {HTMLElement} form 
   * @param {HTMLElement} submitButton 
   * @param {Array.HTMLElement} fields
   * @returns 
   */
  const _initValidation = function (form, submitButton, fields) {
    return REZFUSION.fieldsValidation({
      form: form,
      submitButton: submitButton,
      fields: fields
    });
  }

  /**
   * Hide form.
   */
  const _hideForm = function () {
    _form.style.display = 'none';
  }

  /**
   * Show form.
   */
  const _showForm = function () {
    _form.style.display = '';
  }

  /**
   * Get component element.
   * @returns {HTMLElement}
   */
  const _getElement = function () {
    return _form;
  }

  _init(_form, _submitButton);

  return {
    reset: _reset,
    show: _showForm,
    hide: _hideForm,
    element: _getElement
  }
};
