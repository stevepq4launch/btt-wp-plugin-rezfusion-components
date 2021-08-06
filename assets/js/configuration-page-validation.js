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
            ]
        });
    };
    window.addEventListener('load', initializeValidator);
})();