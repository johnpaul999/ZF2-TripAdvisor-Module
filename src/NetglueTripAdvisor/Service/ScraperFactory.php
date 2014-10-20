<?php
/**
 * Factory to return a configured scraper instance
 */

namespace NetglueTripAdvisor\Service;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use NetglueTripAdvisor\Scraper;

class ScraperFactory implements FactoryInterface
{
    /**
     * Return the configured Scraper
     * @param  ServiceLocatorInterface $serviceLocator
     * @return Scraper
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $config = $serviceLocator->get('NetglueTripAdvisor\ScraperOptions');
        $scraper = new Scraper($config);
        $cache = $serviceLocator->get('NetglueTripAdvisor\Cache');
        $scraper->setCache($cache);
        return $scraper;
    }

}
