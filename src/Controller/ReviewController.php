<?php

namespace Rezfusion\Controller;

use Exception;
use \WP_REST_Response;
use \WP_REST_Request;
use \WP_REST_Server;
use Rezfusion\Entity\Review;
use Rezfusion\EntityManager\ReviewManager;
use Rezfusion\Filters;
use Rezfusion\Options;
use Rezfusion\Query\FindPropertyNameByPostIdQuery;
use Rezfusion\Repository\ReviewRepository;
use Rezfusion\Service\NewReviewCustomerNotificationService;
use Rezfusion\UserRoles;
use Rezfusion\Validator\ReviewValidator;
use RuntimeException;

/**
 * Controller for handling reviews-related requests.
 */
class ReviewController extends AbstractController
{
    /**
     * @inheritdoc
     */
    protected function makeRoutes(): array
    {
        return [
            '/submit-review' => [
                'methods' => WP_REST_Server::CREATABLE,
                'callback' => 'submitReview'
            ],
            '/reviews' => [
                'methods' => WP_REST_Server::READABLE,
                'callback' => 'reviews',
                'allowedRoles' => static::getAllowedUserRoles()
            ],
            '/approve-review/(?P<id>\d+)' => [
                'methods' => WP_REST_Server::READABLE,
                'callback' => 'approveReview',
                'allowedRoles' => static::getAllowedUserRoles()
            ],
            '/disapprove-review/(?P<id>\d+)' => [
                'methods' => WP_REST_Server::READABLE,
                'callback' => 'disapproveReview',
                'allowedRoles' => static::getAllowedUserRoles()
            ],
            '/delete-review/(?P<id>\d+)' => [
                'methods' => WP_REST_Server::READABLE,
                'callback' => 'deleteReview',
                'allowedRoles' => static::getAllowedUserRoles()
            ],
        ];
    }

    /**
     * Fetch collection of reviews.
     * 
     * @param WP_REST_Request
     * 
     * @return WP_REST_Response
     */
    public function reviews(WP_REST_Request $request): WP_REST_Response
    {
        $returnData = [];
        $statusCode = 400;
        try {
            $ReviewRepository = new ReviewRepository();
            $reviewsCollection = $ReviewRepository->getReviews();
            $reviews = [];
            foreach ($reviewsCollection as $Review) {
                $reviews[] = $Review->toArray();
            }
            $returnData = $reviews;
            $statusCode = 200;
        } catch (Exception $Exception) {
        }
        return $this->returnJSON($returnData, $statusCode);
    }

    /**
     * Submit new review.
     * 
     * @param WP_REST_Request
     * 
     * @return WP_REST_Response
     */
    public function submitReview(WP_REST_Request $request): WP_REST_Response
    {
        $returnData = [];
        $statusCode = 400;
        try {
            $reviewData = $request->get_json_params();
            $Review = new Review();
            $ReviewManager = new ReviewManager($Review);
            $ReviewValidator = new ReviewValidator($Review);
            $PropertyNameQuery = new FindPropertyNameByPostIdQuery;

            $Review->setPostId(@$reviewData['postId']);
            $Review->setTitle(@$reviewData['title']);
            $Review->setGuestName(@$reviewData['guestName']);
            $Review->setReview(@$reviewData['review']);
            $Review->setRating(@$reviewData['rating']);
            $Review->setStayDate(@$reviewData['stayDate']);

            if (!empty($Review->getPostId()))
                $Review->setPropertyName($PropertyNameQuery->execute($Review->getPostId()));

            if ($ReviewValidator->validate() === false)
                throw new RuntimeException("Review didn't pass validation.");

            $ReviewManager->save($Review);

            /* Sends notification about new review. */
            try {
                (new NewReviewCustomerNotificationService)->sendEmailNotification(
                    $Review,
                    get_option(Options::newReviewNotificationRecipients())
                );
            } catch (Exception $Exception) {
                // Do nothing, just continue.
            }

            $statusCode = 200;
        } catch (Exception $Exception) {
            $returnData['error'] = $Exception->getMessage();
        }
        return $this->returnJSON($returnData, $statusCode);
    }

    /**
     * Approve review.
     * 
     * @param WP_REST_Request
     * 
     * @return WP_REST_Response
     */
    public function approveReview(WP_REST_Request $request): WP_REST_Response
    {
        $returnData = [];
        $statusCode = 400;
        try {
            if (empty($reviewId = $request->get_param('id')))
                throw new RuntimeException("Invalid Review ID.");
            $ReviewRepository = new ReviewRepository;
            $Review = $ReviewRepository->getReview($reviewId);
            if (!$Review)
                throw new RuntimeException("Review not found.");
            if ($Review->getApproved() === true)
                throw new RuntimeException("Review already approved.");
            $Review->setApproved(true);
            wp_update_comment([
                'comment_ID' => $Review->getId(),
                'comment_approved' => 'approve'
            ]);
            $statusCode = 200;
        } catch (Exception $Exception) {
            $returnData['error'] = $Exception->getMessage();
        }
        return $this->returnJSON($returnData, $statusCode);
    }

    /**
     * Disapprove review.
     * 
     * @param WP_REST_Request
     * 
     * @return WP_REST_Response
     */
    public function disapproveReview(WP_REST_Request $request): WP_REST_Response
    {
        $returnData = [];
        $statusCode = 400;
        try {
            if (empty($reviewId = $request->get_param('id')))
                throw new RuntimeException("Invalid Review ID.");
            $ReviewRepository = new ReviewRepository;
            $Review = $ReviewRepository->getReview($reviewId);
            if (!$Review)
                throw new RuntimeException("Review not found.");
            if ($Review->getApproved() === false)
                throw new RuntimeException("Review is not approved.");
            $Review->setApproved(false);
            wp_update_comment([
                'comment_ID' => $Review->getId(),
                'comment_approved' => 'hold'
            ]);
            $statusCode = 200;
        } catch (Exception $Exception) {
            $returnData['error'] = $Exception->getMessage();
        }
        return $this->returnJSON($returnData, $statusCode);
    }

    /**
     * Delete review.
     * 
     * @param WP_REST_Request
     * 
     * @return WP_REST_Response
     */
    public function deleteReview(WP_REST_Request $request): WP_REST_Response
    {
        $returnData = [];
        $statusCode = 400;
        try {
            if (empty($reviewId = $request->get_param('id')))
                throw new RuntimeException("Invalid Review ID.");
            $ReviewRepository = new ReviewRepository;
            $Review = $ReviewRepository->getReview($reviewId);
            if (!$Review)
                throw new RuntimeException("Review not found.");
            $ReviewRepository = new ReviewRepository();
            $ReviewRepository->deleteReview($Review->getId());
            $statusCode = 200;
        } catch (Exception $Exception) {
            $returnData['error'] = $Exception->getMessage();
        }
        return $this->returnJSON($returnData, $statusCode);
    }

    /**
     * Get array of user roles that are allow to access reviews.
     * 
     * @todo This should be moved to Configuration class.
     * 
     * @return string[]
     */
    public static function getAllowedUserRoles()
    {
        return apply_filters(Filters::reviewsAllowedUserRoles(), [UserRoles::administrator(), UserRoles::editor()]);
    }
}
