<?php
namespace NetglueTripAdvisor\View\Helper;

use Zend\View\Helper\AbstractHelper;

class Reviews extends AbstractHelper
{

    /**
     * Reviews Array
     * @var array
     */
    private $reviews;

    /**
     * URL of the remote reviews page
     * @var string
     */
    private $url;

    /**
     * Construct with an array of reviews
     * @param  array  $reviews
     * @param  string $url
     * @return void
     */
    public function __construct(array $reviews, $url)
    {
        $this->setReviews($reviews);
        $this->setReviewsUrl($url);
    }

    /**
     * Invoke
     * @return self
     */
    public function __invoke()
    {
        return $this;
    }

    /**
     * Set Reviews Array
     * @param  array $reviews
     * @return self
     */
    public function setReviews(array $reviews)
    {
        $this->reviews = $reviews;

        return $this;
    }

    /**
     * Set Reviews URL
     * @param  string $url
     * @return self
     */
    public function setReviewsUrl($url)
    {
        $this->url = $url;

        return $this;
    }

    /**
     * Get Reviews URL
     * @return string
     */
    public function getReviewsUrl()
    {
        return $this->url;
    }

    /**
     * Get Reviews Array (There are normally 10 max)
     * @param int|null $count max number of reviews to return or null to return all found
     * @return array
     */
    public function getReviews($count = null)
    {
        if(is_null($count) || $count >= count($this->reviews)) {
            return $this->reviews;
        }

        return array_slice($this->reviews, 0, $count--);
    }

    /**
     * Render reviews partial
     * @return string
     */
    public function __toString()
    {
        return (string) $this->getView()->partial('netglue_tripadvisor/reviews', array(
            'reviews' => $this->reviews,
        ));
    }

}
