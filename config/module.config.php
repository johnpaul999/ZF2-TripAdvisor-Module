<?php

return array(
	'netglue_tripadvisor' => array(
	    'scraper' => array(
	        /**
	         * You should fill this in with the absolute url of the reviews page on TA
	         * i.e. 'http://www.tripadvisor.co.uk/Hotel_Review-g186338-d187591-Reviews-The_Ritz_London-London_England.html'
	         */
	        'url' => null,

	        /**
	         * Only Relevant if you want to customise the http client
	         */
	        'httpClientOptions' => array(
                'maxredirects'    => 2,
                'useragent'       => 'NetGlue TripAdvisor Module',
                'timeout'         => 2,
            ),

            /**
             * Most of the xpath queries are hard coded but this is the class name of the review div
             */
            'reviewClass' => 'reviewSelector',
        ),
	),

    /**
     * Uses the \Zend\Cache\Service\StorageCacheAbstractServiceFactory to create a cache that
     * by default stores to the filesystem in /tmp for 1 hour
     *
     * You should really overrride this with a longer cache in a directory you and the
     * web server have access to, or configure memcache etc...
     */
    'caches' => array(
        'NetglueTripAdvisor\Cache' => array(
            'adapter' => 'filesystem',
            'options' => array(
                'ttl' => 3600,
                'dirPermission' => 0777,
                'filePermission' => 0666,
            ),
        ),
    ),

	/**
	 * The following sets up the view helper to render the reviews to a view script
	 */
	'view_manager' => array(

		'template_map' => array(

			/**
			 * Override this in your own config to set a different view script
			 * to be used for rendering output from the tripAdvisor() view helper
			 */
			'netglue_tripadvisor/reviews' => __DIR__ . '/../view/reviews-template.phtml',

		),
	),


);
