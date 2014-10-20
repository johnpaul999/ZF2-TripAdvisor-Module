<?php

namespace NetglueTripAdvisor;

use Zend\Stdlib\AbstractOptions;

class ScraperOptions extends AbstractOptions
{

    /**
     * URL to scrape
     * @var string|null
     */
    protected $url;

    /**
     * HTTP Client Options
     * @var array
     */
    protected $httpClientOptions;

    /**
     * @var string Review div class
     */
    protected $reviewClass;

    /**
     * Set Scraper url
     * @param  string $url
     * @return self
     */
    public function setUrl($url)
    {
        $this->url = $url;

        return $this;
    }

    /**
     * Return url to scrape
     * @return string|null
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * Set HTTP Client Options
     * @param  array $options
     * @return self
     */
    public function setHttpClientOptions(array $options)
    {
        $this->httpClientOptions = $options;

        return $this;
    }

    /**
     * Return HTTP Client Options
     * @return array
     */
    public function getHttpClientOptions()
    {
        return $this->httpClientOptions;
    }

    /**
     * Set Review Div Class
     * @param  string $class
     * @return self
     */
    public function setReviewClass($class)
    {
        $this->reviewClass = (string) $class;

        return $this;
    }

    /**
     * Get Review Div Class
     * @return string $class
     */
    public function getReviewClass()
    {
        return $this->reviewClass;
    }

}
