<?php
/**
 * Factory to return a single feed as configured
 * @author George Steel <george@net-glue.co.uk>
 * @copyright Copyright (c) 2013 Net Glue Ltd (http://netglue.co)
 * @license http://opensource.org/licenses/MIT
 */

namespace NetglueTripAdvisor\Service;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use NetglueTripAdvisor\Model\Feed;

class FeedFactory implements FactoryInterface {
	
	/**
	 * Return the configured feed
	 * @param ServiceLocatorInterface $serviceLocator
	 * @return Options
	 */
	public function createService(ServiceLocatorInterface $serviceLocator) {
		$config = $serviceLocator->get('Config');
		$options = isset($config['netglue_tripadvisor']) ?
			$config['netglue_tripadvisor'] :
			array();
		
		if(!isset($options['feed'])) {
			throw new \RuntimeException('No feed has been specified in configuration: [\'netglue_tripadvisor\'][\'feed\']');
		}
		$feed = new Feed($options['feed']);
		// Implement caching here...
		return $feed;
	}
	
}