<!-- Review Submit Section -->
<section class="rezfusion-review-submit">
  <div class="rezfusion-review-submit__wrap">
    <div class="rezfusion-review-submit__add-review">
      <button class="rezfusion-review-submit__add-review-button" rezfusion-modal-target="#rezfusion-review-submit__modal"><?php echo $addReviewButtonText; ?></button>
    </div>
  </div>
  <?php echo rezfusion_modal_open('rezfusion-review-submit__modal'); ?>
    <form id="rezfusion-review-submit__form" class="rezfusion-review-form">
      <div class="rezfusion-review-form__field-wrap rezfusion-review-form__field-wrap--name">
        <label for="rezfusion-review-submit__form__name" class="rezfusion-review-form__label rezfusion-review-form__label--name">Name:</label>
        <input type="text" id="rezfusion-review-submit__form__name" class="rezfusion-review-form__field rezfusion-review-form__field--name" name="review-guest-name" />
      </div>
      <div class="rezfusion-review-form__field-wrap rezfusion-review-form__field-wrap--rating">
        <label for="rezfusion-review-submit__form__rating" class="rezfusion-review-form__label rezfusion-review-form__label--rating">Rating:</label>
        <input type="number" id="rezfusion-review-submit__form__rating" class="rezfusion-review-form__field rezfusion-review-form__field--rating" name="review-rating" />
      </div>
      <div class="rezfusion-review-form__field-wrap rezfusion-review-form__field-wrap--date">
        <label for="rezfusion-review-submit__form__stay-date" class="rezfusion-review-form__label rezfusion-review-form__label--date">Stay Date:</label>
        <input type="date" id="rezfusion-review-submit__form__stay-date" class="rezfusion-review-form__field rezfusion-review-form__field--date" name="review-stay-date" />
      </div>
      <div class="rezfusion-review-form__field-wrap rezfusion-review-form__field-wrap--title">
        <label for="rezfusion-review-submit__form__title" class="rezfusion-review-form__label rezfusion-review-form__label--title">Title:</label>
        <input type="text" id="rezfusion-review-submit__form__title" class="rezfusion-review-form__field rezfusion-review-form__field--title" name="review-title" />
      </div>
      <div class="rezfusion-review-form__field-wrap rezfusion-review-form__field-wrap--content">
        <label for="rezfusion-review-submit__form__review" class="rezfusion-review-form__label rezfusion-review-form__label--content">Review:</label>
        <textarea id="rezfusion-review-submit__form__review" class="rezfusion-review-form__field rezfusion-review-form__field--content" name="review-content"></textarea>
      </div>
      <div class="rezfusion-review-form__field-wrap rezfusion-review-form__field-wrap--submit">
        <button type="submit" class="rezfusion-review-form__field rezfusion-review-form__field--submit"><?php _e("Submit"); ?></button>
      </div>
    </form>
    <div id="rezfusion-review-submit__form__message-container"></div>
  <?php echo rezfusion_modal_close(); ?>
</section>
<!-- End Review Submit Section -->
<script>
  (function() {
    /**
     * Handle review submit form and modal components.
     */
    document.addEventListener('DOMContentLoaded', function() {
      const postId = <?php echo json_encode(get_the_ID()); ?>;
      REZFUSION.starsRating({
        element: document.getElementsByName('review-rating')[0]
      });
      let form = document.getElementById('rezfusion-review-submit__form');
      let formInstance = REZFUSION.reviewSubmitForm({
        form: form,
        submitButton: form.querySelector('.rezfusion-review-form__field--submit'),
        messageContainer: document.getElementById('rezfusion-review-submit__form__message-container'),
        postId: postId
      });
      let instance = REZFUSION.modal({
        element: document.getElementById('rezfusion-review-submit__modal')
      });
      instance.on('show', function(e) {
        formInstance.reset();
        formInstance.show();
      });
    });
  })();
</script>