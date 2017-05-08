<?php
/**
 * Created by PhpStorm.
 * User: brodriguez
 * Date: 22/02/17
 * Time: 01:02 PM
 */

namespace Facturacion;

class Module
{

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
        return array();
    }


}