<?php
/**
 * Created by PhpStorm.
 * User: brodriguez
 * Date: 11/02/17
 * Time: 01:03 AM
 */

namespace Kardex;

use Kardex\Form\FiltrosInventarioFieldset;
use Kardex\Mapper\DetallesLoteMapper;
use Kardex\Mapper\DocumentoMapper;
use Kardex\Mapper\FiltrosProductoMapper;
use Kardex\Mapper\IngresoMapper;
use Kardex\Mapper\InventarioMapper;
use Kardex\Mapper\LoteMapper;
use Zend\Db\Adapter\AdapterAwareInterface;
use Zend\ModuleManager\Feature\FormElementProviderInterface;
use Zend\Mvc\MvcEvent;

class Module implements FormElementProviderInterface
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
            'factories' => array(
                'InventarioMapper' => function ($sm) {
                    $dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
                    $mapper = new InventarioMapper($dbAdapter);
                    return $mapper;
                },
                'LoteMapper' => function ($sm) {
                    $dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
                    $mapper = new LoteMapper($dbAdapter);
                    return $mapper;
                },
                'DetallesLoteMapper' => function ($sm) {
                    $dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
                    $mapper = new DetallesLoteMapper($dbAdapter);
                    return $mapper;
                },
                'FiltrosProductoMapper' => function ($sm) {
                    $dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
                    $mapper = new FiltrosProductoMapper($dbAdapter);
                    return $mapper;
                },
                'DocumentoMapper' => function ($sm) {
                    $dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
                    $mapper = new DocumentoMapper($dbAdapter);
                    return $mapper;
                },
                'IngresoMapper' => function ($sm) {
                    $dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
                    $mapper = new IngresoMapper($dbAdapter);
                    return $mapper;
                },
            ),
        );
    }

    public function getFormElementConfig()
    {
        return array(
            'factories' => array(
                'Kardex\Form\FiltrosInventarioForm' => 'Kardex\Factory\FiltrosInventarioFormFactory',
                'Kardex\Form\MovimientoFieldset' => 'Kardex\Factory\MovimientoFieldsetFactory'
            ),
        );
    }



}