<tr valign="top">
    <th>
    </th>
    <td class="rezfusion-floor-plans-configuration__header">
        <?php _e('Custom Floor Plans URL-s'); ?>
    </td>
</tr>
<script>
    (function() {
        function floorPlansConfiguration(element, saveButton, wordpressNonce, $) {

            const BASE_CLASS = 'rezfusion-floor-plans-configuration';
            const ROW_CLASS = BASE_CLASS + '__row';
            const LABEL_CLASS = ROW_CLASS + '__label';
            const URL_INPUT_CLASS = ROW_CLASS + '__url';
            const REST_URL_PREFIX = '/wp-json/rezfusion';
            const FETCH_FLOOR_PLANS_URL = REST_URL_PREFIX + '/floor-plans';
            const UPDATE_FLOOR_PLANS_URL = REST_URL_PREFIX + '/update-floor-plans';
            let data = [];

            function makeRequestParameters(url) {
                return {
                    url: url,
                    headers: {
                        'X-WP-Nonce': wordpressNonce
                    }
                };
            }

            function post(url, data) {
                const requestParameters = makeRequestParameters(url);
                requestParameters.data = JSON.stringify(data);
                requestParameters.dataType = 'json';
                requestParameters.contentType = 'application/json';
                return $.post(requestParameters);
            }

            function get(url) {
                return $.get(makeRequestParameters(url));
            };

            function update() {
                return fetchData().then(function(fetchedData) {
                    data = fetchedData.items;
                    render();
                }).catch(function(error) {
                    alert(error.message);
                });
            }

            function render() {
                $('.' + ROW_CLASS).remove();
                data.forEach(function(datum) {
                    element.append(renderItem(datum));
                });
            }

            function save() {
                return post(UPDATE_FLOOR_PLANS_URL, {
                    items: data
                });
            }

            function setLock(lock) {
                saveButton.disabled = lock && true;
                $('.' + URL_INPUT_CLASS).attr('disabled', lock && true);
            }

            function handleSave() {
                setLock(true);
                save().catch().always(function() {
                    update().then(function() {
                        setLock(false);
                    });
                });
            }

            function saveButtonOnClick(event) {
                event.preventDefault();
                handleSave();
                return false;
            }

            function renderItem(data) {
                const row = document.createElement('tr');
                const labelColumn = document.createElement('th');
                const inputColumn = document.createElement('td');
                const label = document.createElement('label');
                const urlInput = document.createElement('input');
                const postID = data.postID;
                const inputName = "property-floor-plan-url-" + postID;

                labelColumn.append(label);
                labelColumn.setAttribute('scope', 'row');

                inputColumn.append(urlInput);

                label.classList.add(LABEL_CLASS);
                label.append(data.propertyName + ' (post ID: ' + postID + ')');
                label.for = inputName;

                urlInput.classList.add(URL_INPUT_CLASS);
                urlInput.value = data.url;
                urlInput.placeholder = 'N/D';
                urlInput.type = 'text';
                urlInput.oninput = function(event) {
                    data.url = event.currentTarget.value;
                };
                urlInput.name = inputName;

                row.classList.add(ROW_CLASS);
                row.setAttribute('valign', 'top');
                row.append(labelColumn);
                row.append(inputColumn);

                return row;
            }

            function fetchData() {
                return get(FETCH_FLOOR_PLANS_URL);
            }

            function initialize() {
                element.classList.add(BASE_CLASS);
                update();
                saveButton.onclick = saveButtonOnClick;
            }

            initialize();
        }

        document.addEventListener('DOMContentLoaded', function() {
            floorPlansConfiguration(
                document.getElementsByClassName('form-table')[0],
                document.getElementById('submit'),
                <?php echo json_encode(wp_create_nonce('wp_rest')); ?>,
                jQuery
            );
        });
    })();
</script>