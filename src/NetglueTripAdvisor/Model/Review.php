<?php

namespace NetglueTripAdvisor\Model;

use DateTime;

use Zend\Feed\Reader\Entry\EntryInterface as Entry;

class Review {
	
	protected $entry;
	
	/**
	 * Rating as an int between 0 and 5
	 * @var int
	 */
	protected $rating;
	
	/**
	 * Description, without rating prefix
	 * @var string
	 */
	protected $description;
	
	/**
	 * pubDate property as a DateTime object
	 * @var DateTime
	 */
	protected $date;
	
	public function __construct(Entry $entry) {
		$this->entry = $entry;
		$this->extractDescription();
	}
	
	/**
	 * Return review creation date
	 * @return DateTime
	 */
	public function getDateCreated() {
		if($this->date) {
			return $this->date;
		}
		$this->date = $this->entry->getDateCreated();
		return $this->date;
	}
	
	/**
	 * Return a link to the full review on trip advisor
	 * @return string
	 */
	public function getLink() {
		return $this->entry->getLink();
	}
	
	/**
	 * Return review title
	 * @return string
	 */
	public function getTitle() {
		return $this->entry->getTitle();
	}
	
	/**
	 * Return the rating out of 5
	 * @return int
	 */
	public function getStarRating() {
		return $this->rating;
	}
	
	/**
	 * Return review excerpt
	 * @return string
	 */
	public function getBody() {
		return $this->description;
	}
	
	/**
	 * An alias for getBody()
	 * @return string
	 */
	public function getDescription() {
		return $this->getBody();
	}
	
	/**
	 * Return author
	 * @return string|void
	 */
	public function getAuthor() {
		$author = $this->entry->getAuthor();
		if(is_string($author)) {
			return $author;
		}
		if(is_array($author) && isset($author['name'])) {
			return $author['name'];
		}
	}
	
	/**
	 * Extract description and star rating into separate properties
	 * @return void
	 */
	protected function extractDescription() {
		$desc = $this->entry->getDescription();
		$pattern = '/^TripAdvisor[[:ascii:]]+\: ([0-5])([[:alnum:]\s]+)([<br\/>\s]+)(.+)$/is';
		if(preg_match($pattern, $desc, $match)) {
			$this->rating = (int) $match[1];
			$this->description = trim($match[4]);
		} else {
			$this->description = $desc;
		}
	}
	
}