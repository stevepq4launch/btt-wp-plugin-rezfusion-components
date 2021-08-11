/**
 * Handles modal element for viewing reviews.
 * @param {Object} options
 * @returns {Object}
 */
const rezfusionReviewsModalHandler = function (options = {}) {

    /**
     * @var {Array.Object}
     */
    const _reviews = options.reviews;

    /**
     * @var {Array.HTMLElement}
     */
    const _triggersElements = options.triggersElements;

    /**
     * @var {rezfusionModal}
     */
    const _previewModal = options.modalInstance;

    /**
     * @var {HTMLElement}
     */
    const _titleElement = options.titleElement;

    /**
     * @var {HTMLElement}
     */
    const _ratingElement = options.ratingElement;

    /**
     * @var {HTMLElement}
     */
    const _contentElement = options.contentElement;

    /**
     * @var {HTMLElement}
     */
    const _stayDateElement = options.stayDateElement;

    /**
     * @var {HTMLElement}
     */
    const _guestNameElement = options.guestNameElement;

    /**
     * @var {HTMLElement}
     */
    const _previousReviewButton = options.previousReviewButton;

    /**
     * @var {HTMLElement}
     */
    const _nextReviewButton = options.nextReviewButton;

    /**
     * @var {HTMLElement}
     */
    const _starsRatingElement = document.createElement('input');

    _ratingElement.append(_starsRatingElement);

    /**
     * @var {rezfusionStarsRating}
     */
    const _starsRatingInstance = REZFUSION.starsRating({
        element: _starsRatingElement,
        editable: false
    });

    /**
     * Find index by review ID.
     * @param {Number} reviewId 
     * @returns {Number|String|null}
     */
    const _findReviewIndex = function (reviewId) {
        let review = null;
        _reviews.forEach(function (review_, index) {
            if (review_.id == reviewId) {
                review = index;
                return false;
            }
        });
        return review;
    }

    /**
     * Update modal component data.
     * @param {Object} review 
     */
    const _updateModal = function (review) {
        _titleElement.innerHTML = review.title;
        _contentElement.innerHTML = review.review;
        _stayDateElement.innerHTML = review.stayDate;
        _guestNameElement.innerHTML = review.guestName;
        _starsRatingInstance.setValue(review.rating);
    }

    /**
     * Update navigation button element.
     * @param {HTMLElement} buttonElement 
     * @param {Number|String|null} reviewId 
     */
    const _updateNavigationButton = function (buttonElement, reviewId) {
        if (reviewId !== null) {
            buttonElement.onclick = function () {
                _update(reviewId);
            }
            buttonElement.style.visibility = "visible";
        } else {
            buttonElement.onclick = null;
            buttonElement.style.visibility = "hidden";
        }
    }

    /**
     * Update component.
     * @param {Number|String|null} reviewIndex 
     */
    const _update = function (reviewIndex = null) {
        _updateModal(_reviews[reviewIndex]);
        let previousReviewIndex = reviewIndex - 1;
        let nextReviewIndex = reviewIndex + 1;
        if (nextReviewIndex > _reviews.length - 1)
            nextReviewIndex = null;
        if (previousReviewIndex < 0)
            previousReviewIndex = null;
        _updateNavigationButton(_previousReviewButton, previousReviewIndex);
        _updateNavigationButton(_nextReviewButton, nextReviewIndex);
    }

    /**
     * Handle trigger.
     * @param {HTMLElement} trigger 
     */
    const _handleTrigger = function (trigger) {
        let reviewId = trigger.getAttribute('data-review-id');
        if (!reviewId) {
            return true;
        }
        trigger.addEventListener('click', function (event) {
            let reviewIndex = _findReviewIndex(reviewId);
            if (reviewIndex !== null && reviewIndex >= 0) {
                _update(reviewIndex);
                _previewModal.show();
            }
        });
    }

    /**
     * Initialize functionality.
     */
    const _init = function () {
        _triggersElements.forEach(_handleTrigger);
    }

    _init();
};