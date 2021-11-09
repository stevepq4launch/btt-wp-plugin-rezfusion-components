/**
 * Rezfusion modal component.
 * @param {Object} options {element: HTMLElement, closeElement: HTMLElement, triggerElement: HTMLElement}
 * @returns {Object}
 */
function rezfusionModal(options = {}) {

    /**
     * @var {HTMLElement}
     */
    const _modalElement = options.element || null;

    /**
     * @var {HTMLElement}
     */
    let _closeElement = options.closeElement || null;

    /**
     * @var {HTMLElement}
     */
    let _triggerElement = options.triggerElement || null;

    /**
     * @var {HTMLElement}
     */
    const _contentElement = options.contentElement || null;

    /**
     * @var {Object}
     */
    const _events = {};

    /**
     * Add new event.
     * @param {String} type 
     * @param {function} callback 
     */
    const _on = function (type, callback) {
        if (typeof _events[type] === 'undefined')
            _events[type] = [];
        _events[type].push(callback);
    }

    /**
     * Handle trigger element.
     * @param {HTMLElement} triggerElement 
     * @param {HTMLElement} modalElement 
     */
    const _handleTrigger = function (triggerElement, modalElement) {
        triggerElement.addEventListener('click', function () {
            (modalElement) && _showModal(modalElement);
        });
    }

    /**
     * Create a new object for event.
     * @param {String} type 
     * @returns {Object}
     */
    const makeEventObject = function (type) {
        return {
            event: type
        }
    }

    /**
     * Handle events of specific type.
     * @param {String} type 
     */
    const _handleEvents = function (type) {
        if (typeof _events[type] !== 'undefined' && _events[type].length) {
            _events[type].forEach(function (callback) {
                callback(makeEventObject(type));
            })
        }
    }

    /**
     * Initialize component.
     * @param {HTMLElement} modalElement 
     * @param {HTMLElement} closeElement 
     */
    const _initializeModal = function (modalElement, closeElement) {
        _initializeCloseElement(closeElement);
    };

    /**
     * Initialize close element.
     * @param {HTMLElement} closeElement
     */
    const _initializeCloseElement = function (closeElement) {
        closeElement && closeElement.addEventListener('click', function (event) {
            _closeModal();
        });
    };

    /**
     * Window *click* event function.
     * @param {Object} event 
     * @param {HTMLElement} modalElement 
     * @param {function} listener 
     */
    const _onWindowClick = function (event, modalElement, listener) {
        if (event.target === modalElement) {
            window.removeEventListener('click', listener);
            _closeModal();
        }
    };

    /**
     * Handle window *click* event.
     * @param {HTMLElement} modalElement 
     */
    const _handleOnWindowClick = function (modalElement) {
        setTimeout(function () {
            const onClick = function (event) {
                _onWindowClick(event, modalElement, onClick);
            }
            window.addEventListener('click', onClick);
        }, 10);
    }

    /**
     * Show modal.
     */
    const _showModal = function () {
        jQuery(_modalElement).css('display', 'flex').hide().fadeIn(200, 'swing');
        _handleOnWindowClick(_modalElement);
        _handleEvents('show');
    }

    /**
     * Close modal.
     */
    const _closeModal = function () {
        _modalElement.style.display = 'none';
    }

    /**
     * Get element.
     * @returns {HTMLElement}
     */
    const _element = function () {
        return _modalElement;
    }

    /**
     * Set content.
     * @param {String|HTMLElement} content 
     */
    const _setContent = function (content = '') {
        if (_contentElement) {
            _contentElement.innerHTML = '';
            _contentElement.append(content);
        }
    }

    /**
     * Update selected options.
     * @param {object} options 
     */
    const _updateOptions = function (options = {}) {
        if (typeof options.triggerElement !== 'undefined') {
            _triggerElement = options.triggerElement || null;
            (_triggerElement) && _handleTrigger(_triggerElement, _modalElement);
        }
        if (typeof options.closeElement !== 'undefined') {
            _closeElement = options.closeElement || null;
            (_closeElement) && _initializeCloseElement(_closeElement);
        }
    };

    _initializeModal(_modalElement, _closeElement);
    (_triggerElement) && _handleTrigger(_triggerElement, _modalElement);

    return {
        on: _on,
        close: _closeModal,
        show: _showModal,
        element: _element,
        setContent: _setContent,
        updateOptions: _updateOptions
    };
}