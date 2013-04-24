<?php

namespace NetglueTripAdvisor\Model;

use Zend\Feed\Reader\Reader;
use Zend\Cache\Storage\StorageInterface as Cache;

class Feed {
	
	/**
	 * Uri of the feed
	 * @var string
	 */
	protected $feedUri;
	
	/**
	 * The Feed object
	 * @var Zend\Feed\Reader\Feed\FeedInterface|NULL
	 */
	protected $feed;
	
	/**
	 * Array of Review instances
	 * @var array
	 */
	protected $entries = array();
	
	/**
	 * Cache Adapter
	 * @var Cache|NULL
	 */
	protected $cache;
	
	/**
	 * Optionally provide the feed uri to the constructor
	 * @param string $feedUri
	 * @return void
	 */
	public function __construct($feedUri = NULL) {
		if(NULL !== $feedUri) {
			$this->setFeedUri($feedUri);
		}
	}
	
	/**
	 * Set Cache
	 * @param Cache $cache
	 * @return Feed $this
	 */
	public function setCache(Cache $cache) {
		$this->cache = $cache;
		return $this;
	}
	
	/**
	 * Return cache adapter
	 * @return Cache|NULL
	 */
	public function getCache() {
		return $this->cache;
	}
	
	/**
	 * Set remote feed uri
	 * @param string $feedUri
	 * @return Feed $this
	 */
	public function setFeedUri($feedUri) {
		$this->feedUri = $feedUri;
		return $this;
	}
	
	/**
	 * Return current feed uri
	 * @return string|void
	 */
	public function getFeedUri() {
		return $this->feedUri;
	}
	
	/**
	 * Load the feed into a property and return it
	 * @return Zend\Feed\Reader\Feed\FeedInterface
	 * @throws \RuntimeException if the feed has not been set, or it's not possible to load the feed
	 */
	protected function loadXml() {
		if($this->feed) {
			return $this->feed;
		}
		if($this->cache) {
			Reader::setCache($this->cache);
		}
		if(NULL === $this->feedUri) {
			throw new \RuntimeException('No feed uri has been set. Cannot load RSS');
		}
		try {
			$this->feed = Reader::import($this->feedUri);
		} catch(\Exception $e) {
			throw new \RuntimeException('Failed to load the feed '.$this->feedUri, NULL, $e);
		}
		foreach($this->feed as $entry) {
			$this->entries[] = new Review($entry);
		}
		return $this->feed;
	}
	
	/**
	 * Return the Feed
	 * @return Zend\Feed\Reader\Feed\FeedInterface
	 * @see loadXml()
	 */
	public function getFeed() {
		return $this->loadXml();
	}
	
	/**
	 * Return the Uri for this locations list of reviews on trip advisor
	 * @return string
	 */
	public function getReviewListUri() {
		return $this->loadXml()->getLink();
	}
	
	/**
	 * Return the review exceprts from the current feed optionally limiting to the specified number
	 * @param int $count
	 * @return array
	 */
	public function getReviews($count = NULL) {
		$this->loadXml();
		if(empty($count) || (int) $count > count($this->entries)) {
			return $this->entries;
		}
		return array_slice($this->entries, 0, $count);
	}
}