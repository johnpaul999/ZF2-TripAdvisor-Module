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

    'caches' => array(
        'NetglueTripAdvisor\Cache' => array(
            'adapter' => 'filesystem',
            'ttl' => 3600,
        ),
    ),

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
