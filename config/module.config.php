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

	'scraper' => array(
	    'url' => null,
	    'httpClientOptions' => array(
	        'maxredirects'    => 2,
            'useragent'       => 'NetGlue TripAdvisor Module',
            'timeout'         => 2,
	    ),
	    'reviewClass' => 'reviewSelector',
	),
);

/**
 * Return config keyed with 'netglue_tripadvisor'
 */
return array(
	'netglue_tripadvisor' => $config,

	/**
	 * The following sets up the view helper to render the reviews to a view script
	 */
	'view_manager' => array(

		'template_map' => array(

			// Override this in your own config to set a different view script for the helper
			'netglue_tripadvisor/reviews' => __DIR__ . '/../view/reviews-template.phtml',

		),
	),
	/**
	 * The view helper itself is not very interesting - it just receives the single
	 * configured feed and renders a partial passing the feed onto the view script
	 */
	'view_helpers' => array(
		'factories' => array(
			'NetglueTripAdvisor\View\Helper\Reviews' => function($sm) {
				$sl = $sm->getServiceLocator();
				$feed = $sl->get('NetglueTripAdvisor\Model\Feed');
				$helper = new NetglueTripAdvisor\View\Helper\Reviews;
				$helper->setFeed($feed);
				return $helper;
			},
		),
		'aliases' => array(
			'ngTripAdvisorFeed' => 'NetglueTripAdvisor\View\Helper\Reviews',
		),
	),

);
