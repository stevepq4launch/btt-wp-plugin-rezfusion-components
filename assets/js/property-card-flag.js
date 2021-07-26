/**
 * Function adds flags to elements ("teasers") of properties list.
 * @param {HTMLElement} componentElement
 * @param {Array} propertiesKeys
 */
function propertyCardFlag(componentElement, propertiesKeys = [], flagText = '') {

    const _componentElement = componentElement;
    const _propertiesKeys = propertiesKeys;
    const _flagText = flagText;
    const resultsListClassName = 'bt-results-list';
    const teaserClassName = 'bt-teaser';
    const teaserWithFlagClassName = teaserClassName + '--with-flag';
    const flagClassName = 'bt-teaser__flag';
    let doUpdateTimeout = null;

    /**
     * Create 
     * @param {String} text 
     * @returns {HTMLElement}
     */
    function makeFlag(text) {
        let flagElement = document.createElement('div');
        flagElement.classList.add(flagClassName);
        flagElement.append(text);
        return flagElement;
    }

    /**
     * Add flag to element (if it doesn't exist).
     * @param {HTMLElement} teaserElement
     */
    function addFlag(teaserElement) {
        if (teaserElement.className.indexOf(teaserWithFlagClassName) === -1) {
            teaserElement.append(makeFlag(_flagText));
            teaserElement.classList.add(teaserWithFlagClassName);
        }
    }

    /**
     * Get elements of results list.
     * @param {HTMLElement} componentElement
     * 
     * @returns {HTMLElement}
     */
    function getResultsListElements(componentElement) {
        return componentElement.querySelectorAll('.' + resultsListClassName + ' .' + teaserClassName);
    }

    /**
     * Update set of elements.
     * @param {Array} propertiesKeys
     * @param {Array} elements
     */
    function update(propertiesKeys, elements) {
        elements.forEach(function (element) {
            let propertyKey = findPropertyKey(element);
            (propertyKey && checkPropertyKey(propertyKey, propertiesKeys)) && addFlag(element);
        });
    }

    /**
     * Find property key (id) from element.
     * @param {HTMLElement} teaserElement
     * @returns {String|null}
     */
    function findPropertyKey(teaserElement) {
        let linkElement = teaserElement.querySelector('.bt-teaser__link');
        if (!linkElement)
            return null;
        let PMS_Id = teaserElement.querySelector('.bt-teaser__link').getAttribute('href').split("?")[1].split("&")[0].replace('pms_id=', '');
        return PMS_Id || null;
    }

    /**
     * Get results list.
     * @param {HTMLElement} componentElement 
     * @returns {HTMLElement}
     */
    function getResultsListElement(componentElement) {
        return componentElement.querySelectorAll('.' + resultsListClassName)[0];
    }

    /**
     * Check if property key is valid to include a flag.
     * @param {String} propertyKey 
     * @param {Array} propertiesKeys 
     * @returns {Boolean}
     */
    function checkPropertyKey(propertyKey, propertiesKeys) {
        return (propertiesKeys.indexOf(propertyKey) !== -1) ? true : false;
    }

    /**
     * Initialize events.
     * @param {HTMLElement} componentElement 
     */
    function initializeEvents(componentElement) {
        function callback() {
            let resultsListElement = getResultsListElement(componentElement);
            if (typeof resultsListElement !== 'undefined' && resultsListElement) {
                componentElement.removeEventListener('DOMSubtreeModified', callback);
                resultsListElement.addEventListener('DOMSubtreeModified', function () {
                    doUpdate();
                });
                doUpdate();
            }
        }
        componentElement.addEventListener('DOMSubtreeModified', callback);
    }

    /**
     * Handle update operation.
     */
    function doUpdate() {
        function clearDoUpdateTimeout() {
            if (doUpdateTimeout !== null) {
                clearTimeout(doUpdateTimeout);
                doUpdateTimeout = null;
            }
        }
        clearDoUpdateTimeout();
        doUpdateTimeout = setTimeout(function () {
            update(_propertiesKeys, getResultsListElements(_componentElement));
            clearDoUpdateTimeout();
        }, 100);
    }

    /**
     * Initialize feature.
     * @param {HTMLElement} componentElement 
     */
    function initialize(componentElement) {
        initializeEvents(componentElement);
    }

    initialize(componentElement);
}