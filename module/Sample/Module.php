<?php
/**
 * Created by PhpStorm.
 * User: brodriguez
 * Date: 11/02/17
 * Time: 01:03 AM
 */

namespace Sample;


use Zend\Db\Adapter\AdapterAwareInterface;
use Zend\Mvc\MvcEvent;

class Module
{
    public function onBootstrap(MvcEvent $e){

    }

    public function getConfig()
    {
        return include __DIR__ . '/config/module.config.php';
    }

    public function getAutoloaderConfig()
    {
        return array(
            'Zend\Loader\StandardAutoloader' => array(
                'namespaces' => array(
                    __NAMESPACE__ => __DIR__ . '/src/' . __NAMESPACE__,
                )
            ),
        );
    }

    public function getServiceConfig()
    {
        return array(
            'initializers' => array(
                function($instance, $serviceManager) {
                    if ($instance instanceof AdapterAwareInterface) {
                        $instance->setDbAdapter($serviceManager->get('Zend\Db\Adapter\Adapter'));
                    }
                }
            ),
            'invokables' => array(
                'Sample\Model\CountryTable' => 'Sample\Model\CountryTable',
                'Sample\Model\StateTable' => 'Sample\Model\StateTable'
            )
        );
    }
}