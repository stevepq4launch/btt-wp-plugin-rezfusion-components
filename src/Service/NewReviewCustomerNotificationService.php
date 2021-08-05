<?php

namespace Rezfusion\Service;

use InvalidArgumentException;
use Rezfusion\Entity\Review;

/**
 * Service prepares and sends e-mail notification about new review to interested parts.
 * @todo Inject subject/message factory/builder?
 * @todo Inject mails handler?
 */
class NewReviewCustomerNotificationService
{
    /**
     * @param Review $Review
     * 
     * @return string
     */
    protected function makeSubject(Review $Review): string
    {
        return sprintf(__("New review from %s"), $Review->getGuestName());
    }

    /**
     * @param Review $Review
     * 
     * @return string
     */
    protected function makeMessage(Review $Review): string
    {
        return sprintf(
            __("%s, who was your guest on %s, has submitted a new review:\n%s"),
            $Review->getGuestName(),
            $Review->getStayDate(),
            $Review->getReview()
        );
    }

    /**
     * Send email notification to customer.
     * 
     * @param Review $Review
     * @param string|string[] $to
     * @throws InvalidArgumentException
     * 
     * @return bool
     */
    public function sendEmailNotification(Review $Review, $to = ''): bool
    {
        if (empty($to))
            throw new InvalidArgumentException("Empty e-mail address.");
        $subject = $this->makeSubject($Review);
        $message = $this->makeMessage($Review);
        return (!empty($to)
            && !empty($subject)
            && !empty($message))
            ? wp_mail($to, $subject, $message)
            : false;
    }
}
