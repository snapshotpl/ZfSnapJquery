<?php

namespace ZfSnapJquery\Libraries;

use Zend\ServiceManager\FactoryInterface;
use \Zend\ServiceManager\ServiceLocatorInterface;

/**
 * Jquery Factory
 *
 * @author Witold Wasiczko <witold@wasiczko.pl>
 */
class JqueryFactory implements FactoryInterface
{

    /**
     * @param ServiceLocatorInterface $serviceLocator
     * @return \ZfSnapJquery\Libraries\Jquery
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $config = $serviceLocator->get('config');
        $configJquery = $config['zf_snap_jquery']['libraries']['jquery'];

        $jquery = $serviceLocator->get('jquery-class');
        /* @var $jquery \ZfSnapJquery\Libraries\Jquery */
        $jquery->setVersion($configJquery['version']);
        $jquery->setCdnScript($configJquery['script']);
        $jquery->setEnabled($configJquery['enabled']);
        $jquery->setNoConflictMode($configJquery['noConflictMode']);

        return $jquery;
    }
}
