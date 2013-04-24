<?php
/**
 * Base Configuration for the Module
 * @author George Steel <george@net-glue.co.uk>
 * @copyright Copyright (c) 2012 Net Glue Ltd (http://netglue.co)
 * @license http://opensource.org/licenses/MIT
 */

/**
 * Options for the module that are critical to its operation
 */
$config = array(
	
	/**
	 * Simplest operation - Provide a feed uri, turn on cache_by_default and
	 * uncomment the cache adapter config and it should be working out of the box
	 * with:
	 * $feed = $serviceLocator->get('NetglueTripAdvisor\Model\Feed');
	 * $reviews = $feed->getReviews();
	 * foreach($reviews as $r) {
	 *   var_dump($r->getTitle());
	 *   var_dump($r->getStarRating()); // etc...
	 * }
	 */
	
	'feed' => NULL, // To use the single feed service, you have to provide the full uri of a trip advisor feed
	
	/**
	 * This should be set to true if you want the module to attempt caching.
	 * Bear in mind that all that happens in reality, is that any cache storage engine
	 * created is simply provided to Zend\Feed\Reader\Reader::setCache() ultimately,
	 * so if you're consuming feeds in other ways using the Zend Reader, you might be
	 * better off explicity setting the cache in Reader yourself somewhere else and
	 * leaving the cache turned off here.
	 *
	 */
	'cache_by_default' => false,
	
	/**
	 * A default filesystem cache adapter that will cache to /tmp
	 *
	 * If there is a system wide cache available, and you'd prefer that to be used,
	 * Just make sure that the whole cache option is commented out and 
	 * NetglueTripAdvisor\Service\CacheFactory will return the cache you have setup
	 * in main config.
	 */
	/*
	'cache' => array(
		'adapter' => array(
			'name' => 'filesystem',
			'options' => array(
				
			),
		),
		'plugins' => array(
			
		),
	),
	*/
);

/**
 * Return config keyed with 'netglue_tripadvisor'
 */
return array(
	'netglue_tripadvisor' => $config,
);
