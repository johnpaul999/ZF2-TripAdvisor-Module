<?php
/**
 * Factory to return the view helper for rendering trip advisor reviews
 */

namespace NetglueTripAdvisor\Service;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

use NetglueTripAdvisor\View\Helper\Reviews as ViewHelper;

class ViewHelperFactory implements FactoryInterface
{
    /**
     * Return the configured Scraper
     * @param  ServiceLocatorInterface $serviceLocator
     * @return Scraper
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {

        $appServices = $serviceLocator->getServiceLocator();
        $options = $appServices->get('NetglueTripAdvisor\ScraperOptions');
        $scraper = $appServices->get('NetglueTripAdvisor\Scraper');

        $helper = new ViewHelper($scraper->getReviews(), $options->getUrl());

        return $helper;
    }

}
