<?php

namespace ZfSnapJquery\Libraries;

use Zend\ServiceManager\FactoryInterface;
use \Zend\ServiceManager\ServiceLocatorInterface;

/**
 * Jqueryui Factory
 *
 * @author Witold Wasiczko <witold@wasiczko.pl>
 */
class JqueryuiFactory implements FactoryInterface
{
    /**
     *
     * @param ServiceLocatorInterface $serviceLocator
     * @return \ZfSnapJquery\Libraries\Jqueryui
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $config = $serviceLocator->get('config');
        $configJquery = $config['zf_snap_jquery']['libraries']['jquery-ui'];

        $jquery = $serviceLocator->get('jquery-ui-class');
        /* @var $jquery \ZfSnapJquery\Libraries\Jqueryui */
        $jquery->setVersion($configJquery['version']);
        $jquery->setCdnScript($configJquery['cdnScript']);
        $jquery->setScript($configJquery['script']);
        $jquery->setEnabled($configJquery['enabled']);
        $jquery->setTheme($configJquery['theme']);
        $jquery->setCdnStyle($configJquery['cdnStyle']);
        $jquery->setStyle($configJquery['style']);

        return $jquery;
    }
}
