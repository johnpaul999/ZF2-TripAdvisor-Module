<?php
namespace NetglueTripAdvisor;

/**
 * Autoloader
 */
use Zend\Loader\AutoloaderFactory;
use Zend\Loader\StandardAutoloader;
use Zend\ModuleManager\Feature\AutoloaderProviderInterface;

/**
 * Service Provider
 */
use Zend\ModuleManager\Feature\ServiceProviderInterface;

/**
 * Config Provider
 */
use Zend\ModuleManager\Feature\ConfigProviderInterface;

/**
 * Bootstrap Listener
 */

class Module implements
    AutoloaderProviderInterface,
    ServiceProviderInterface,
    ConfigProviderInterface
{

    /**
     * Return autoloader configuration
     * @link http://framework.zend.com/manual/2.0/en/user-guide/modules.html
     * @return array
     */
    public function getAutoloaderConfig()
    {
        return array(
            AutoloaderFactory::STANDARD_AUTOLOADER => array(
                StandardAutoloader::LOAD_NS => array(
                    __NAMESPACE__ => __DIR__,
                ),
            ),
        );
    }

    /**
     * Include/Return module configuration
     * @return array
     * @implements ConfigProviderInterface
     */
    public function getConfig()
    {
        return include __DIR__ . '/../../config/module.config.php';
    }

    /**
     * Return Service Config
     * @return array
     * @implements ServiceProviderInterface
     */
    public function getServiceConfig()
    {
        return include __DIR__ . '/../../config/services.config.php';
    }

}
