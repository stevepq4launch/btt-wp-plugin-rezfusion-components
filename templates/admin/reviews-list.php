<div id="rezfusion-reviews">
    <h1><?php _e("Reviews List"); ?></h1>
    <div class="notice notice-warning"><?php _e("Only Wordpress internal reviews are listed here."); ?></div>
    <div id="rezfusion-reviews__table"></div>
    <div class="rezfusion-modal" id="rezfusion-reviews__review-preview">
        <div class="rezfusion-modal__wrap">
            <span class="rezfusion-modal__close">&times;</span>
            <div id="rezfusion-reviews__review-preview__content"></div>
        </div>
    </div>
</div>
<script>
    (function() {
        const wordpressNonce = <?php echo json_encode(wp_create_nonce('wp_rest')); ?>;
        document.addEventListener('DOMContentLoaded', function() {
            const viewReviewModalElement = document.getElementById('rezfusion-reviews__review-preview');
            ConfigurationReviewsListViewHandler(
                wordpressNonce,
                REZFUSION.modal({
                    element: viewReviewModalElement,
                    contentElement: viewReviewModalElement.querySelector('#rezfusion-reviews__review-preview__content'),
                    closeElement: viewReviewModalElement.querySelector('.rezfusion-modal__close')
                })
            );
        });
    })();
</script>