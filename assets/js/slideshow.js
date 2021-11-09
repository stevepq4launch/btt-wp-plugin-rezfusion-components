(function () {

    /** @var {string} */
    const slideshowContainerClassName = 'lodging-item-details__photos';

    /**
     * Slideshow component handler.
     * @param {HTMLElement|null} slideshowContainer
     */
    function slideshowHandler(slideshowContainer = null) {

        const initializationDelay = 10;

        if (!slideshowContainer)
            return;

        /** @var {HTMLElement} */
        const galleryWrapper = slideshowContainer.querySelector('.bt-gallery-tile__wrapper');

        /** @var {array} */
        const updateEvents = ['resize', 'orientationchange', 'scroll'];

        /**
         * Get gallery container.
         * @returns {HTMLElement}
         */
        function getCloseButton() {
            return slideshowContainer.querySelector('[class^=Photos__DetailsSlideshowClose]');
        }

        /**
         * Get window height.
         * @returns {int}
         */
        function getHeight() {
            return window.innerHeight;
        }

        /**
         * Get height of thumbnails panel.
         * @returns {int}
         */
        function getThumbnailsPanelHeight() {
            return slideshowContainer.querySelector('.image-gallery-thumbnails-wrapper').offsetHeight;
        }

        /**
         * Event handler.
         */
        function eventHandler() {
            update();
        };

        /**
         * Initialize events.
         */
        function initializeEvents() {
            updateEvents.forEach(function (eventName) {
                window.addEventListener(eventName, eventHandler);
            });
        }

        /**
         * Update slideshow height.
         */
        function update() {
            const height = getHeight();
            const photosDetailsSlideshow = slideshowContainer.querySelector('[class*=Photos__DetailsSlideshow]');
            const other = slideshowContainer.querySelector('.image-gallery-content .image-gallery-slide-wrapper');
            photosDetailsSlideshow.style.height = height + 'px';
            other.style.height = (height - getThumbnailsPanelHeight()) + 'px';
        }

        /**
         * Initialize functionality.
         */
        function initialize() {
            initializeEvents();
            getCloseButton().addEventListener('click', function () {
                destroy();
            })
            update();
        }

        /**
         * Destroy events.
         */
        function destroy() {
            updateEvents.forEach(function (eventName) {
                window.removeEventListener(eventName, eventHandler);
            });
        }

        galleryWrapper.addEventListener('click', function () {
            setTimeout(function () { initialize(); }, initializationDelay);
        });
    }

    /**
     * Wait for slideshow element to render and initialize.
     */
    function waitAndInitialize() {
        let checks = 0;
        let handlerInitInterval = setInterval(function () {
            try {
                checks++;
                if (checks === 20) {
                    removeInterval();
                }
                const slideshowContainer = document.querySelector('.' + slideshowContainerClassName);
                if (!slideshowContainer) {
                    return;
                }
                removeInterval();
                slideshowHandler(slideshowContainer);
            } catch (error) {
                removeInterval();
                console.error(error.message);
            }
        }, 200);
        function removeInterval() {
            clearInterval(handlerInitInterval);
        }
    }

    document.addEventListener('DOMContentLoaded', waitAndInitialize);

})();