<?php
/**
 * Service Configuration
 */
return array(
	'factories' => array(
		'NetglueTripAdvisor\Model\Feed' => 'NetglueTripAdvisor\Service\FeedFactory',
		'NetglueTripAdvisor\Cache' => 'NetglueTripAdvisor\Service\CacheFactory',
	),
);
