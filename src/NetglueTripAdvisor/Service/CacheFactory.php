<?php
namespace NetglueTripAdvisor\Service;

use Zend\Cache\Service\StorageCacheFactory;
use Zend\ServiceManager\ServiceLocatorInterface;
use Zend\Cache\StorageFactory;

class CacheFactory extends StorageCacheFactory {
	
	public function createService(ServiceLocatorInterface $serviceLocator) {
		$config = $serviceLocator->get('Config');
		$taConfig = isset($config['netglue_tripadvisor']['cache']) ? $config['netglue_tripadvisor']['cache'] : false;
		// Return global cache adapter if it is configured and a specific adapter is not configured for this module
		if(isset($config['cache']) && false === $taConfig) {
			return parent::createService($serviceLocator);
		}
		$cache = StorageFactory::factory($taConfig);
		return $cache;
	}
	
}