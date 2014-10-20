<?php
/**
 * Service Configuration
 */
return array(
	'factories' => array(
		'NetglueTripAdvisor\Cache' => 'NetglueTripAdvisor\Service\CacheFactory',
		'NetglueTripAdvisor\ScraperOptions' => 'NetglueTripAdvisor\Service\ScraperOptionsFactory',
		'NetglueTripAdvisor\Scraper' => 'NetglueTripAdvisor\Service\ScraperFactory',
	),
	'abstract_factories' => array(
	    'Zend\Cache\Service\StorageCacheAbstractServiceFactory',
	),
);
