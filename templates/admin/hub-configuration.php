<div class="rezfusion-hub-configuration">
    <div>
        <button id="refresh-hub-configuration-button" class="button button-primary"><i class="fas fa-redo"></i> Refresh</button>
        <button id="update-hub-configuration-button" class="button button-primary"><i class="fas fa-cloud-download-alt"></i> Fetch and update configuration</button>
    </div>
    <h2><?php _e('Current configuration'); ?>:</h2>
    <div class="rezfusion-configuration-container">
        <pre class="rezfusion-configuration-container__configuration"></pre>
    </div>
</div>
<style>
    .rezfusion-configuration-container {
        font-family: monospace;
        background: #fff;
        box-sizing: content-box;
        width: 98%;
        overflow: auto;
        height: 70vh;
    }

    .rezfusion-configuration-container__configuration {
        padding: 5px;
    }
</style>
<script>
    (function($, wordpressNonce, refreshConfigurationButton, updateConfigurationButton, configurationContainer) {

        const handleResponseError = function(response) {
            (typeof response.responseText !== 'undefined') ?
            alert(response.responseText): alert("Unknown error.");
        };

        const get = function(url) {
            return $.get({
                url: url,
                headers: {
                    'X-WP-Nonce': wordpressNonce
                }
            });
        };

        const reloadConfiguration = function() {
            return get('/wp-json/rezfusion/configuration/reload').then(function(result) {
                return result;
            });
        };

        const loadConfiguration = function() {
            return get('/wp-json/rezfusion/configuration').then(function(result) {
                return result;
            });
        };

        const renderConfigurationInContainer = function() {
            return loadConfiguration().then(function(result) {
                configurationContainer.innerHTML = JSON.stringify(result, null, 2);
            }).catch(handleResponseError);
        };

        updateConfigurationButton.onclick = function(event) {
            const button = this;
            const callback = function() {
                button.disabled = false;
                refreshConfigurationButton.disabled = false;
            }
            button.disabled = true;
            refreshConfigurationButton.disabled = true;
            reloadConfiguration().then(function() {
                renderConfigurationInContainer().always(callback);
            }).catch(function(response) {
                handleResponseError(response);
                callback();
            });
        };

        refreshConfigurationButton.onclick = function(event) {
            const button = this;
            button.disabled = true;
            renderConfigurationInContainer().always(function() {
                button.disabled = false;
            });
        }

        renderConfigurationInContainer();
    })(
        jQuery,
        <?php echo json_encode(wp_create_nonce('wp_rest')); ?>,
        document.getElementById('refresh-hub-configuration-button'),
        document.getElementById('update-hub-configuration-button'),
        document.querySelector('.rezfusion-configuration-container__configuration')
    );
</script>