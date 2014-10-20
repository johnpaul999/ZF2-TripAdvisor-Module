<?php
/**
 * Service Configuration
 */
return array(
	'factories' => array(
		'NetglueTripAdvisor\Cache' => 'NetglueTripAdvisor\Service\CacheFactory',
		'NetglueTripAdvisor\Scraper' => 'NetglueTripAdvisor\Service\ScraperFactory',
	),
);
