/**
 * Main container for Rezfusion components/widgets/functions/helpers.
 * @var {Object}
 */
const REZFUSION = (function () {

    /**
     * @var {String}
     */
    const MODAL_COMPONENT_NAME = 'rezfusionModal';

    /**
     * @var {String}
     */
    const TABLE_COMPONENT_NAME = 'rezfusionTable';

    /**
     * @var {String}
     */
    const STARS_RATING_COMPONENT_NAME = 'rezfusionStarsRating';

    /**
     * @var {String}
     */
    const REVIEW_SUBMIT_FORM_COMPONENT_NAME = 'rezfusionReviewSubmitForm';

    /**
     * @var {String}
     */
    const FIELDS_VALIDATION_COMPONENT_NAME = 'rezfusionFieldsValidation';

    const NAME_TO_COMPONENT_MAP = {
        modal: MODAL_COMPONENT_NAME,
        table: TABLE_COMPONENT_NAME,
        starsRating: STARS_RATING_COMPONENT_NAME,
        reviewSubmitForm: REVIEW_SUBMIT_FORM_COMPONENT_NAME,
        fieldsValidation: FIELDS_VALIDATION_COMPONENT_NAME
    };

    /**
     * @var {Array.Object}
     */
    const _cache = [];

    /**
     * Find cached instance of component.
     * @param {HTMLElement} element 
     * @param {String} componentType 
     * @returns {Object|null}
     */
    const _findInstance = function (element, componentType) {
        let instance = null;
        _cache.forEach(function (cached) {
            if (typeof cached.instance.element === 'undefined')
                return true;
            if (element === cached.instance.element() && cached.componentType === componentType) {
                instance = cached.instance;
                return false;
            }
        });
        return instance;
    }

    /**
     * Make a new cached item for component instance.
     * @param {Object} componentInstance 
     * @param {String} componentType 
     * @returns {Object}
     */
    const _makeCached = function (componentInstance, componentType) {
        return {
            instance: componentInstance,
            componentType: componentType
        }
    }

    /**
     * Wrapper for caching instances of components.
     * @param {rezfusionModal} rezfusionModal 
     * @param {String} componentType
     * @returns {function}
     */
    const _cacheWrapper = function (rezfusionComponent, componentType) {
        return function (options) {
            let instance = _findInstance(options.element, componentType);
            if (instance === null) {
                instance = rezfusionComponent(options);
                _cache.push(_makeCached(instance, componentType));
            } else if (instance) {
                /* Update existing instance options. */
                if (typeof instance.updateOptions === 'function') {
                    instance.updateOptions(options);
                }
            }
            return instance;
        }
    }

    /**
     * Automatically initialize modal components by finding selectors.
     * @param {rezfusionModal} rezfusionModal 
     * @param {String} modalBaseClass 
     * @param {String} modalCloseClass 
     * @param {String} targetAttribute 
     */
    const _initializeRezfusionModals = function (rezfusionModal, modalBaseClass, modalCloseClass, targetAttribute) {

        const _modals = document.querySelectorAll('.' + modalBaseClass);
        const _triggers = document.querySelectorAll('[' + targetAttribute + ']');

        const _findTrigger = function (modalElement) {
            let foundTrigger;
            _triggers.forEach(function (triggerElement) {
                let modalElement_ = document.querySelector(triggerElement.getAttribute(targetAttribute));
                if (modalElement_ === modalElement) {
                    foundTrigger = triggerElement
                    return false;
                }
            });
            return foundTrigger;
        }

        _modals.forEach(function (modalElement) {
            rezfusionModal({
                element: modalElement,
                closeElement: modalElement.querySelector('.' + modalCloseClass),
                triggerElement: _findTrigger(modalElement)
            });
        });
    }

    /**
     * Function replacing unknown/non-existing component.
     */
    const _unknownComponent = function () {
        alert("Component doesn't exist or wasn't initialized.");
    }

    /**
     * Prepare component function.
     * @param {String} componentType 
     * @returns {function}
     */
    const _prepareComponent = function (componentType) {
        return function (options) {
            return (typeof window[componentType] === 'undefined')
                ? _unknownComponent
                : (_cacheWrapper(window[componentType], componentType))(options);
        }
    }

    /**
     * Setup components.
     */
    const _setup = function () {
        document.addEventListener('DOMContentLoaded', function () {
            _initializeRezfusionModals(
                _prepareComponent(MODAL_COMPONENT_NAME),
                'rezfusion-modal',
                'rezfusion-modal__close',
                'rezfusion-modal-target'
            );
        });
    }

    /**
     * Prepare object with named components.
     * @param {Object} nameToComponentMap 
     * @returns {Object}
     */
    const _prepareComponentsObject = function (nameToComponentMap) {
        let components = {};
        for (let name in nameToComponentMap) {
            components[name] = _prepareComponent(nameToComponentMap[name]);
        }
        return components;
    }

    _setup();

    return _prepareComponentsObject(NAME_TO_COMPONENT_MAP);
})();