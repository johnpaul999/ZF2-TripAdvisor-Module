<?php
/**
 * Factory to return a configured scraper instance
 */

namespace NetglueTripAdvisor\Service;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

use NetglueTripAdvisor\ScraperOptions;

class ScraperOptionsFactory implements FactoryInterface
{
    /**
     * Return the configured Scraper
     * @param  ServiceLocatorInterface $serviceLocator
     * @return Scraper
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $config = $serviceLocator->get('Config');
        $options = isset($config['netglue_tripadvisor']['scraper']) ?
            $config['netglue_tripadvisor']['scraper'] :
            array();

        return new ScraperOptions($options);
    }

}
