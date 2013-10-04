<?php

namespace ZfSnapJquery\View\Helper;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

/**
 * Jquery view helper Factory
 *
 * @author Witold Wasiczko <witold@wasiczko.pl>
 */
class JqueryFactory implements FactoryInterface
{

    /**
     * @param ServiceLocatorInterface $serviceLocator
     * @return \ZfSnapJquery\View\Helper\Jquery
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $serviceManager = $serviceLocator->getServiceLocator();
        $config = $serviceManager->get('config');//zf_snap_jquery
        $configJquery = $config['zf_snap_jquery']['view-helpers']['jquery'];

        $helper = $serviceManager->get('jquery-view-helper-class');
        /* @var $helper \ZfSnapJquery\View\Helper\Jquery */
        $helper->addLibrary($serviceManager->get('jquery'));
        $helper->addLibrary($serviceManager->get('jquery-ui'));
        $helper->setAppendToOwnHelper($configJquery['appendToOwnHelper']);

        return $helper;
    }
}
