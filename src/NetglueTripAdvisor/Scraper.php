<?php

namespace NetglueTripAdvisor;

use NetglueTripAdvisor\Model\Review;

use Traversable;
use Zend\Stdlib\ArrayUtils;

use Zend\Http\Client;
use Zend\Http\Client\Exception\ExceptionInterface as HttpException;

use DomDocument;
use DOMXpath;
use DomElement;
use DateTime;
use Zend\Uri\Uri;

class Scraper
{
    /**
     * @var ScraperOptions Options object
     */
    private $options;

    /**
     * @var Client Http Client
     */
    private $client;

    /**
     * The HTML we'll be scraping for reviews
     * @var string
     */
    private $html;

    /**
     * @param ScraperOptions|Traversable|array $options Options Object or array
     */
    public function __construct($options)
    {
        $this->setOptions($options);
    }

    /**
     * @param  array|Traversable                  $options Options array or object
     * @return self
     * @throws Exception\InvalidArgumentException if parameter is not the correct type
     */
    public function setOptions($options)
    {
        if (!$options instanceof ScraperOptions) {
            if (!is_array($options) && !$options instanceof Traversable) {
                throw new Exception\InvalidArgumentException(sprintf(
                    '%s expects an array or instance of Traversable. Recieved %s',
                    __METHOD__,
                    gettype($options)));
            }
            if (!is_array($options)) {
                $options = ArrayUtils::iteratorToArray($options);
            }
            $options = new ScraperOptions($options);
        }
        $this->options = $options;

        return $this;
    }

    /**
     * Get Options
     * @return ScraperOptions
     */
    public function getOptions()
    {
        return $this->options;
    }

    /**
     * Return HTTP Client
     * @return Client
     */
    public function getHttpClient()
    {
        if (!$this->client) {
            $options = $this->getOptions();
            $client = new Client($options->getUrl(), $options->getHttpClientOptions());
            $this->setHttpClient($client);
        }

        return $this->client;
    }

    /**
     * Set/Override HTTP Client
     * @param  Client $client
     * @return self
     */
    public function setHttpClient(Client $client)
    {
        $this->client = $client;

        return $this;
    }

    /**
     * Return the original HTML content for the remote reviews page
     * @return string
     */
    public function getHtml()
    {
        if (!$this->html) {
            $client = $this->getHttpClient();
            try {
                $response = $client->send();
                if (!$response->isSuccess()) {
                    throw new Exception\RuntimeException('Failed to load remote source HTML: '.$response->getReasonPhrase(), $response->getStatusCode());
                }
                $this->setHtml($response->getBody());
            } catch (HttpException $e) {
                throw new Exception\RuntimeException('Failed to load remote source HTML', null, $e);
            }
        }

        return $this->html;
    }

    /**
     * Set the HTML to be parsed
     * @param  string $html
     * @return self
     */
    public function setHtml($html)
    {
        $this->html = (string) $html;

        return $this;
    }

    public function extract()
    {
        $libXmlErrorHandlerState = libxml_use_internal_errors(true);
        $dom = new DomDocument;
        try {
            if (false === $dom->loadHtml('<?xml encoding="utf-8" ?>' . $this->getHtml())) {
                throw new Exception\RuntimeException('Failed to load invalid HTML');
            }
            $xpath = new DOMXpath($dom);
            $reviewClass = $this->getOptions()->getReviewClass();
            $reviews = array();
            foreach ($xpath->query("//div[contains(@class, '{$reviewClass}')]") as $node) {
                $reviews[] = $this->extractReview($node);
            }
            libxml_use_internal_errors($libXmlErrorHandlerState);

            return $reviews;
        } catch (\Exception $e) {
            // Reset Error Handling State on Exception
            libxml_use_internal_errors($libXmlErrorHandlerState);
            throw $e;
        }
    }

    public function extractReview(DomElement $node)
    {
        $review = new Review;
        $doc = new DomDocument;
        $html = $node->ownerDocument->saveHtml($node);
        $doc->loadHtml('<?xml encoding="utf-8" ?>' . $html);
        $xpath = new DOMXpath($doc);

        /**
         * Author Username
         * // member_info/ * /username/span
         */
        $nodes = $xpath->query("//div[contains(@class, 'member_info')]/*/div[contains(@class, 'username')]/span");
        if ($nodes->length === 1) {
            $review->setAuthor(trim($nodes->item(0)->nodeValue));
        }
        /**
         * Author Location
         */
        $nodes = $xpath->query("//div[contains(@class, 'member_info')]/div[contains(@class, 'location')]");
        if ($nodes->length === 1) {
            $review->setAuthorLocation(trim($nodes->item(0)->nodeValue));
        }
        /**
         * Review Permalink
         */
        $nodes = $xpath->query("//div[contains(@class, 'quote')]/a");
        if ($nodes->length === 1) {
            // URL linked to from the title is an absolute path without host/scheme
            // Also, URL contains a fragment that should be removed
            $path = trim($nodes->item(0)->getAttribute('href'));
            $url = new Uri($this->getOptions()->getUrl());

            $new = sprintf('%s://%s/%s', $url->getScheme(), $url->getHost(), ltrim($path, '/'));
            $url = new Uri($new);
            $url->setFragment(null);
            $review->setUrl((string) $url);
        }

        /**
         * Title Quote
         */
        $nodes = $xpath->query("//div[contains(@class, 'quote')]/a/span[contains(@class, 'noQuotes')]");
        if ($nodes->length === 1) {
            $review->setTitle(trim($nodes->item(0)->nodeValue));
        }
        /**
         * Rating
         */
        $nodes = $xpath->query("//div[contains(@class, 'rating')]/span[contains(@class, 'rate')]/img");
        if ($nodes->length === 1) {
            $img = $nodes->item(0);
            $alt = $img->getAttribute('alt');
            if (preg_match('/([0-9\.]+)\s[\w]+\s([0-9\.]+)/', $alt, $match)) {
                $review->setStarRating((float) $match[1]);
                $review->setMaxStarRating((float) $match[2]);
            }
        }
        /**
         * Rating Date
         */
        $nodes = $xpath->query("//div[contains(@class, 'rating')]/span[contains(@class, 'ratingDate')]");
        if ($nodes->length === 1) {
            $dateString = $nodes->item(0)->getAttribute('title');
            $review->setDate(DateTime::createFromFormat('d F Y', $dateString));
        }

        /**
         * Review Excerpt
         */
        $nodes = $xpath->query("//div[contains(@class, 'entry')]/p[contains(@class, 'partial_entry')]");
        if ($nodes->length === 1) {
            // Use first child node->nodeValue to skip links for 'more...'
            $review->setExcerpt(trim($nodes->item(0)->childNodes->item(0)->nodeValue));
        }

        return $review;
    }

}
