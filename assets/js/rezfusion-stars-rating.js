/**
 * *Stars* rating widget.
 * @param {Object} options {element: HTMLElement, editable: Boolean}
 * @returns {Object}
 */
function rezfusionStarsRating(options = {}) {

    /**
     * @var {HTMLElement|null}
     */
    const _originalInput = options.element || null;

    /**
     * @var {Boolean}
     */
    const _editable = typeof options.editable !== 'undefined' ? options.editable : true;

    /**
     * @var {Number}
     */
    const _maxRating = 5;

    /**
     * @var {String}
     */
    const _baseFieldClassName = 'rezfusion-stars-rating';

    /**
     * @var {String}
     */
    const _baseStarClassName = _baseFieldClassName + '__star';

    /**
     * @var {String}
     */
    const _fieldHighlightClassName = _baseFieldClassName + "--highlight";

    /**
     * @var {String}
     */
    const _activeStarClassName = _baseStarClassName + "--active";

    /**
     * @var {String}
     */
    const _inactiveStarClassName = _baseStarClassName + "--inactive";

    /**
     * @var {String}
     */
    const _activeStarSymbol = "&#9733;";

    /***
     * @var {String}
     */
    const _inactiveStarSymbol = "&#9734;";

    /**
     * @var {HTMLElement|null}
     */
    let _field = null;

    /**
     * @var {Array}
     */
    let _starsElements = [];

    /**
     * @var {Number|String|null}
     */
    let _value = _originalInput.value;

    /**
     * Update stars elements.
     * @param {Array} starsElements
     * @param {Number} rating
     */
    function _update(starsElements, rating) {
        for (i = 0; i < _maxRating; i++) {
            let starElement = starsElements[i];
            i < rating ? _makeStarActive(starElement) : _makeStarInactive(starElement);
        }
    }

    /**
     * Is field editable?
     * @returns {Boolean}
     */
    function _isEditable() {
        return _editable;
    }

    /**
     * Activate *star* element.
     * @param {HTMLElement} starElement 
     */
    function _makeStarActive(starElement) {
        let classList = starElement.classList;
        classList.remove(_inactiveStarClassName);
        classList.add(_activeStarClassName);
        starElement.innerHTML = _activeStarSymbol;
    }

    /**
     * Deactivate *star* element.
     * @param {HTMLElement} starElement 
     */
    function _makeStarInactive(starElement) {
        let classList = starElement.classList;
        classList.remove(_activeStarClassName);
        classList.add(_inactiveStarClassName);
        starElement.innerHTML = _inactiveStarSymbol;
    }

    /**
     * Highlight stars.
     * @param {Array} starsElements 
     * @param {Number} rating 
     */
    function _highlight(starsElements, rating) {
        _field.classList.add(_fieldHighlightClassName);
        _update(starsElements, rating);
    }

    /**
     * Unhighlight stars.
     * @param {Array} starsElements 
     */
    function _unhighlight(starsElements) {
        _field.classList.remove(_fieldHighlightClassName);
        _update(starsElements, _getValue());
    }

    /**
     * Trigger *input* event.
     */
    function _triggerInput() {
        _originalInput.dispatchEvent(new Event('input'));
    }

    /**
     * Create a new *star* element.
     * @param {Number} rating 
     * @returns {HTMLElement}
     */
    function _makeStarElement(rating) {
        let star = document.createElement('span');
        star.classList.add(_baseStarClassName);
        if (_isEditable() === true) {
            star.onclick = function () {
                _setValue(rating);
            }
            star.onmouseenter = function () {
                _highlight(_starsElements, rating);
            }
            star.onmouseleave = function () {
                _unhighlight(_starsElements);
            }
        }
        return star;
    }

    /**
     * Create a new field.
     * @param {Number} maxRating 
     * @returns {HTMLElement}
     */
    function _makeField(maxRating) {
        let field = document.createElement('div');
        field.classList.add(_baseFieldClassName);
        for (let i = 0; i < maxRating; i++) {
            let star = _makeStarElement(i + 1);
            _starsElements.push(star);
            field.append(star);
        }
        return field;
    }

    /**
     * Handle original *input* field.
     * @param {HTMLElement} input
     */
    function _handleOriginalField(input) {
        input.style.display = 'none';
        input.addEventListener('input', function (event) {
            _setValue(event.currentTarget.value);
        });
    }

    /**
     * Get current value.
     * @returns {Number|String|null}
     */
    const _getValue = function () {
        return _value;
    }

    /**
     * Set current value (and update widget).
     * @param {Number|String|null} value 
     */
    const _setValue = function (value) {
        if (value != _getValue()) {
            _value = value;
            _originalInput.value = value;
            _update(_starsElements, _originalInput.value);
            _triggerInput();
        }
    }

    /**
     * Initialize widget.
     */
    function _init() {
        _field = _makeField(_maxRating);
        _handleOriginalField(_originalInput);
        _update(_starsElements, _getValue());
        _originalInput.parentNode.insertBefore(_field, _originalInput.nextSibling);
    }

    /**
     * Get component element.
     * @returns {HTMLElement}
     */
    function _getElement() {
        return _originalInput;
    }

    _init(_originalInput);

    return {
        setValue: _setValue,
        getValue: _getValue,
        element: _getElement
    };
}