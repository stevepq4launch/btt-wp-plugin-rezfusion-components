(function () {

    /**
     * Initialize data update button.
     * 
     * @param {jQuery} $ 
     * @param {string} wordpressNonce 
     * @param {HTMLElement} fetchDataButton 
     * @param {HTMLElement} messageContainer 
     */
    const dataUpdateHandler = function ($, wordpressNonce, fetchDataButton, messageContainer) {

        /**
         * @var {HTMLElement}
         */
        const dataSyncLogContainer = document.querySelector('#rezfusion-data-refresh-log');
        const dataSyncLogEntriesContainer = dataSyncLogContainer.querySelector('.rezfusion-log__entries');

        /**
         * Send data update request.
         * @returns {Promise}
         */
        const fetchData = function () {
            return get('/wp-json/rezfusion/fetch-data');
        };

        /**
         * Fetch log entries.
         * @returns {Promise}
         */
        const fetchLogEntries = function () {
            return get('/wp-json/rezfusion/data-sync-log-entries');
        };

        const get = function (url) {
            return $.get({
                url: url,
                headers: {
                    'X-WP-Nonce': wordpressNonce
                }
            });
        };

        /**
         * Clear message container.
         */
        const clearMessage = function () {
            $(messageContainer)
                .html('')
                .removeClass(['is-dismissible', 'notice', 'notice-error', 'notice-success'])
                .hide();
        };

        /**
         * Show message.
         * 
         * @param {string} type 'error' or 'success'.
         * @param {string} message
         */
        const setMessage = function (type = '', message = '') {
            clearMessage();
            return $(messageContainer)
                .addClass(['is-dismissible', 'notice', 'notice-' + type])
                .append(
                    $('<p/>').append(message),
                    $('<button/>').attr('type', 'button').addClass('notice-dismiss').on('click', function () {
                        clearMessage();
                    })
                ).show();
        };

        const refreshLogEntries = function () {
            if (!dataSyncLogEntriesContainer) {
                return;
            }
            fetchLogEntries().then(function (response) {
                if (typeof response.entries !== 'undefined') {
                    dataSyncLogEntriesContainer.innerHTML = "";
                    response.entries.reverse().forEach(function (logEntry) {
                        const entryElement = document.createElement('div');
                        entryElement.innerHTML = "&bull; " + logEntry.message;
                        if (typeof logEntry.status !== 'undefined') {
                            entryElement.classList.add('rezfusion-log__entries__entry--' + logEntry.status);
                        }
                        dataSyncLogEntriesContainer.append(entryElement);
                    });
                }
            });
        };

        /**
         * Handle button.
         */
        fetchDataButton.onclick = function () {
            const button = this;
            button.disabled = true;
            fetchData().then(function (response) {
                setMessage('success', response.message);
            }).catch(function (response) {
                setMessage('error', (typeof response.responseJSON !== 'undefined' && response.responseJSON.error) ? response.responseJSON.error : 'Update failed.');
            }).always(function () {
                button.disabled = false;
                refreshLogEntries();
            });
        };

        refreshLogEntries();
    };

    jQuery(document).ready(function () {
        dataUpdateHandler(jQuery,
            document.getElementById('rezfusion-configuration-form').getAttribute('nonce'),
            document.getElementById('rezfusion-hub-fetch-data-button'),
            document.getElementById('rezfusion-hub-fetch-data-message')
        );
    });
})();