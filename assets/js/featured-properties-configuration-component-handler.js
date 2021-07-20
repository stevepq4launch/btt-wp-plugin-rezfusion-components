/**
 * Prepares and initializes "Featured Properties" component.
 * @param  {object} dependencies
 */
function featuredPropertiesConfigurationComponentHandler(dependencies = {}) {

    const _propertyIdField = dependencies.propertyIdField;
    const _propertiesDataSource = dependencies.propertiesDataSource;
    const _useIconsInput = dependencies.useIconsInput;
    const _bedsLabelInput = dependencies.bedsLabelInput;
    const _bathsLabelInput = dependencies.bathsLabelInput;
    const _sleepsLabelInput = dependencies.sleepsLabelInput;
    const _propertiesIdsInput = dependencies.propertiesIdsInput;
    const _propertiesCheckboxListContainer = dependencies.propertiesCheckboxListContainer;
    const _propertiesCountContainer = dependencies.propertiesCountContainer;

    /**
     * Initializes behaviour for selected inputs.
     * @param {HTMLElement} useIconsInput 
     * @param {HTMLElement} bedsLabelInput 
     * @param {HTMLElement} bathsLabelInput 
     * @param {HTMLElement} sleepsLabelInput 
     */
    const handleShortcodeOptions = function (useIconsInput, bedsLabelInput, bathsLabelInput, sleepsLabelInput) {

        const labelInputs = [bedsLabelInput, bathsLabelInput, sleepsLabelInput];

        const changeLabelInputsState = function (enabled = true) {
            labelInputs.forEach(function (input) { input.disabled = !enabled; });
        }

        const update = function () {
            let useIcons = useIconsInput.checked;
            (useIcons === true) && labelInputs.forEach(function (input) { input.value = ''; });
            changeLabelInputsState(!useIcons);
        }

        useIconsInput.onchange = function () { update(); }

        update();
    };

    /**
     * Prepares and renders properties list (checkboxes).
     * @param {Array} properties 
     * @param {HTMLElement} idsInput 
     * @param {HTMLElement} container 
     * @param {HTMLElement} propertiesCountContainer 
     */
    const handlePropertiesList = function (properties = [], idsInput, container, propertiesCountContainer) {

        let checkboxes, currentPropertiesIds, countElement, buttonsContainer, clearSelectionButton, selectAllButton;

        checkboxes = [];
        currentPropertiesIds = idsInput.value ? JSON.parse(idsInput.value.replaceAll("\\", "")) : [];

        countElement = document.createElement('span');
        countElement.style.fontWeight = "bold";

        clearSelectionButton = document.createElement('button');
        clearSelectionButton.classList.add('button', 'button-small');
        clearSelectionButton.append("Clear selection");
        clearSelectionButton.onclick = function (event) {
            event.preventDefault();
            clearSelection();
        };

        selectAllButton = document.createElement('button');
        selectAllButton.classList.add('button', 'button-small');
        selectAllButton.style.marginLeft = '5px';
        selectAllButton.append("Select all");
        selectAllButton.onclick = function (event) {
            event.preventDefault();
            selectAll();
        };

        buttonsContainer = document.createElement('div');
        buttonsContainer.style.display = 'inline-block';
        buttonsContainer.style.marginLeft = '5px';
        buttonsContainer.style.verticalAlign = 'middle';
        buttonsContainer.append(clearSelectionButton, selectAllButton);

        propertiesCountContainer.append("You have ", countElement, " properties selected.");
        propertiesCountContainer.append(buttonsContainer);

        const clearSelection = function () {
            checkboxes.forEach(function (checkbox) {
                checkbox.checked = false;
            });
            currentPropertiesIds = [];
            update();
        }

        const selectAll = function () {
            currentPropertiesIds = [];
            checkboxes.forEach(function (checkbox) {
                checkbox.checked = true;
                currentPropertiesIds.push(checkbox.value);
            });
            update();
        }

        const update = function () {
            idsInput.value = JSON.stringify(currentPropertiesIds);
            countElement.innerHTML = currentPropertiesIds.length;
        }

        const makeCheckBox = function (propertyId, propertyName, checked = false, onChange) {
            const wrapper = document.createElement('div');
            const checkbox = document.createElement('input');
            const label = document.createElement('label');
            checkbox.type = "checkbox";
            checkbox.value = propertyId;
            checkbox.onchange = onChange;
            if (checked === true)
                checkbox.checked = true;
            label.append(checkbox, propertyName);
            wrapper.append(label);
            wrapper.style.marginBottom = '20px';
            return wrapper;
        };

        const addPropertyId = function (propertyId) {
            currentPropertiesIds.indexOf(propertyId) === -1 && currentPropertiesIds.push(propertyId);
        }

        const removePropertyId = function (propertyId) {
            let index = currentPropertiesIds.indexOf(propertyId);
            (index !== -1) && currentPropertiesIds.splice(index, 1);
        }

        const hasPropertyId = function (propertyId) {
            return currentPropertiesIds.indexOf(propertyId) === -1 ? false : true;
        }

        properties.forEach(function (property) {
            let propertyId = property[_propertyIdField];
            let checkbox = makeCheckBox(propertyId, property.post_title, hasPropertyId(propertyId) ? true : false, function (event) {
                let element = event.currentTarget, checked = element.checked;
                checked === true ? addPropertyId(propertyId) : removePropertyId(propertyId);
                update();
            });
            checkboxes.push(checkbox.querySelector('input'));
            container.append(checkbox);
        });
        update();
    }

    /* Initialize all required elements. */
    handleShortcodeOptions(_useIconsInput, _bedsLabelInput, _bathsLabelInput, _sleepsLabelInput);
    handlePropertiesList(_propertiesDataSource, _propertiesIdsInput, _propertiesCheckboxListContainer, _propertiesCountContainer);
}