<?php
/**
 * Factory to return the view helper for rendering trip advisor reviews
 */

namespace NetglueTripAdvisor\Service;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

use NetglueTripAdvisor\View\Helper\Reviews as ViewHelper;
use NetglueTripAdvisor\Exception;

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

        /**
         * Avoid throwing exceptions for frontend usage and favour an empty
         * review list as this is likely to be less ugly looking to visitors...
         */
        try {
            $reviews = $scraper->getReviews();
        } catch(Exception\ExceptionInterface $e) {
            $reviews = array();
        }

        $helper = new ViewHelper($reviews, $options->getUrl());

        return $helper;
    }

}
