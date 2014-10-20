<?php

namespace NetglueTripAdvisor\Model;

use DateTime;

class Review
{
    /**
     * @var string|null Author Username
     */
    protected $author;

    /**
     * @var string|null Author Location
     */
    protected $authorLocation;

    /**
     * @var string|null Review URL
     */
    protected $url;

    /**
     * @var string|null Review title
     */
    protected $title;

    /**
     * @var float|null Star Rating
     */
    protected $rating;

    /**
     * @var float|null Max Star Rating
     */
    protected $maxRating = 5.0;

    /**
     * Review Date
     * @var DateTime|null
     */
    protected $date;

    /**
     * Review Excerpt
     * @var string|null
     */
    protected $excerpt;

    /**
     * Return review creation date
     * @return DateTime
     */
    public function getDateCreated()
    {
        return $this->getDate();
    }

    /**
     * Set the date
     * @param  DateTime $date
     * @return self
     */
    public function setDate(DateTime $date)
    {
        $this->date = $date;

        return $this;
    }

    /**
     * Return the review date.
     *
     * Note: Ignore the time - it is not relevant
     * @return DateTime|null
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * Return a link to the full review on trip advisor
     * @return string|null
     */
    public function getLink()
    {
        return $this->getUrl();
    }

    /**
     * Set Review URL
     * @param  strign $url
     * @return self
     */
    public function setUrl($url)
    {
        $this->url = $url;

        return $this;
    }

    /**
     * Get Review URL
     * @return string|null
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * Return review title
     * @return string|null
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set review title
     * @param  string $title
     * @return self
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Return the rating out of 5
     * @return float|null
     */
    public function getStarRating()
    {
        return $this->rating;
    }

    /**
     * Set the rating out of 5
     * @param  float $rating
     * @return self
     */
    public function setStarRating($rating)
    {
        $this->rating = $rating;

        return $this;
    }

    /**
     * Return the max rating (5)
     * @return float|null
     */
    public function getMaxStarRating()
    {
        return $this->maxRating;
    }

    /**
     * Set the max rating (Default 5)
     * @param  float $rating
     * @return self
     */
    public function setMaxStarRating($rating)
    {
        $this->maxRating = $rating;

        return $this;
    }

    /**
     * Return review excerpt
     * @return string|null
     */
    public function getBody()
    {
        return $this->getExcerpt();
    }

    /**
     * Return review excerpt
     * @return string|null
     */
    public function getExcerpt()
    {
        return $this->excerpt;
    }

    /**
     * Set Excerpt
     * @param  string $excerpt
     * @return self
     */
    public function setExcerpt($excerpt)
    {
        $this->excerpt = $excerpt;

        return $this;
    }

    /**
     * Set Author Username
     * @param  string $username
     * @return self
     */
    public function setAuthor($username)
    {
        $this->author = $username;

        return $this;
    }

    /**
     * Return author
     * @return string|null
     */
    public function getAuthor()
    {
        return $this->author;
    }

    /**
     * Set Author Location
     * @param  string $location
     * @return self
     */
    public function setAuthorLocation($location)
    {
        $this->authorLocation = $location;

        return $this;
    }

    /**
     * Return Author Location
     * @return string|null
     */
    public function getAuthorLocation()
    {
        return $this->authorLocation;
    }

}
