<?php
namespace NetglueTripAdvisor\View\Helper;

use Zend\View\Helper\AbstractHelper;

use NetglueTripAdvisor\Model\Feed;

class Reviews extends AbstractHelper {
	
	protected $feed;
	
	public function setFeed(Feed $feed) {
		$this->feed = $feed;
		return $this;
	}
	
	public function getFeed() {
		return $this->feed;
	}
	
	public function __toString() {
		return (string) $this->getView()->partial('netglue_tripadvisor/reviews', array(
			'feed' => $this->feed,
		));
	}
	
}