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
         * Send data update request.
         * @returns {Promise}
         */
        const fetchData = function () {
            return $.get({
                url: '/wp-json/rezfusion/fetch-data',
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
            });
        };
    };

    jQuery(document).ready(function () {
        dataUpdateHandler(jQuery,
            document.getElementById('rezfusion-configuration-form').getAttribute('nonce'),
            document.getElementById('rezfusion-hub-fetch-data-button'),
            document.getElementById('rezfusion-hub-fetch-data-message')
        );
    });
})();