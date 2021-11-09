/**
 * Handles "Reviews" view.
 * @param {String} wordpressNonce
 */
function ConfigurationReviewsListViewHandler(wordpressNonce, viewModal) {

    /**
     * @var {String}
     */
    const _wordpressNonce = wordpressNonce;

    /**
     * @var {Object}
     */
    const fetchOptions = {
        headers: {
            'X-WP-Nonce': _wordpressNonce
        }
    };

    /**
     * Refresh table data.
     * @returns {Promise}
     */
    const refresh = function () {
        return fetch('/wp-json/rezfusion/reviews', fetchOptions).then(function (result) {
            return result.json();
        }).then(function (json) {
            table.setData(json).refresh();
        }).catch(function(){
            table.setData([]).refresh();
        });
    }

    /**
     * Sends request to delete review.
     * @param {Number} reviewId
     * @returns {Promise}
     */
    const deleteReview = function (reviewId) {
        return fetch('/wp-json/rezfusion/delete-review/' + reviewId, fetchOptions);
    };

    /**
     * Sends request to approve review.
     * @param {Number} reviewId
     * @returns {Promise}
     */
    const approveReview = function (reviewId) {
        return fetch('/wp-json/rezfusion/approve-review/' + reviewId, fetchOptions);
    }

    /**
     * Sends request to disapprove review.
     * @param {Number} reviewId
     * @returns {Promise}
     */
    const disapproveReview = function (reviewId) {
        return fetch('/wp-json/rezfusion/disapprove-review/' + reviewId, fetchOptions);
    }

    /**
     * @var {rezfusionTable}
     */
    const table = REZFUSION.table({
        element: document.getElementById('rezfusion-reviews__table'),
        width: '100%',
        columns: [{
            caption: "ID",
            field: "id"
        },
        {
            caption: "Post ID",
            field: "postId"
        },
        {
            caption: "Title",
            field: "title"
        },
        {
            caption: "Property",
            field: "propertyName"
        },
        {
            caption: "Guest Name",
            field: "guestName",
        },
        {
            caption: "Stay Date",
            field: "stayDate"
        }, {
            caption: "Review Content",
            field: "review",
            template: function (e) {
                e.container.innerHTML = (e.value && e.value.length > 30) ? e.value.substr(0, 29) + " &hellip;" : e.value;
            }
        },
        {
            caption: "Rating",
            field: "rating",
            template: function (e) {
                let input = document.createElement('input');
                input.style.display = 'none';
                input.value = parseInt(e.value);
                e.container.append(input);
                REZFUSION.starsRating({
                    element: input,
                    editable: false
                });
            }
        },
        {
            caption: "Approved",
            field: "approved",
            template: function (e) {
                e.container.append((e.value === true) ? "Yes" : "No");
            }
        },
        {
            caption: "Options",
            template: function (e) {
                let reviewId = e.data.id;
                if (!reviewId)
                    return;

                let viewButton = document.createElement('button');
                viewButton.classList.add('button');
                viewButton.innerHTML = "View";
                viewButton.onclick = function () {
                    _viewReview(e.data.review);
                };
                e.container.append(viewButton);

                let approved = e.data.approved;
                let approvementStateButton = document.createElement('button');
                approvementStateButton.innerHTML = approved ? "Disapprove" : "Approve";
                approvementStateButton.classList.add('button');
                approvementStateButton.addEventListener('click', function (event) {
                    let text = approved ? "Disapprove review with ID " + reviewId + "?" : "Approve review with ID " + reviewId + "?";
                    let callback = approved ? disapproveReview : approveReview;
                    (true === confirm(text)) && callback(reviewId).then(function (result) {
                        refresh();
                    });
                });
                e.container.append(approvementStateButton);

                let deleteButton = document.createElement('button');
                deleteButton.innerHTML = "Delete";
                deleteButton.classList.add('button');
                deleteButton.addEventListener('click', function (event) {
                    (true === confirm("Delete review with ID " + reviewId + "?")) && deleteReview(reviewId).then(function () {
                        refresh();
                    });
                });
                e.container.append(deleteButton);
            }
        }
        ]
    });

    const _viewReview = function (content) {
        viewModal.setContent(content);
        viewModal.show();
    }

    refresh();
};