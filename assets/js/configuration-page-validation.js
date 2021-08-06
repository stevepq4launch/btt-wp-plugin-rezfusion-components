(function () {
    const initializeValidator = function () {
        let form = document.querySelector('.form-table').closest('form');
        REZFUSION.fieldsValidation({
            form: form,
            submitButton: form.querySelector('#submit'),
            fields: [
                {
                    input: document.getElementsByName('rezfusion_hub_custom_listing_slug')[0],
                    validators: ['slug']
                },
                {
                    input: document.getElementsByName('rezfusion_hub_custom_promo_slug')[0],
                    validators: ['slug']
                },
                {
                    input: document.getElementsByName('rezfusion_hub_channel')[0],
                    validators: ['no-ending-slash']
                },
                {
                    input: document.getElementsByName('rezfusion_hub_folder')[0],
                    validators: ['no-ending-slash']
                },
                {
                    input: document.getElementsByName('rezfusion_hub_sps_domain')[0],
                    validators: ['no-ending-slash']
                },
                {
                    input: document.getElementsByName('rezfusion_hub_conf_page')[0],
                    validators: ['no-ending-slash']
                }
            ]
        });
    };
    window.addEventListener('load', initializeValidator);
})();