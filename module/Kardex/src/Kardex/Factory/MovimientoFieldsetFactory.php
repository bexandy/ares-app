<?php
/**
 * Created by PhpStorm.
 * User: brodriguez
 * Date: 03/05/17
 * Time: 10:10 PM
 */

namespace Kardex\Factory;


use Kardex\Form\MovimientoFieldset;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class MovimientoFieldsetFactory implements FactoryInterface
{
    function __invoke()
    {
        // TODO: Implement __invoke() method.
    }

    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $serviceLocator = $sm->getServiceLocator();
        $almacenMapper = $serviceLocator->get('AlmacenMapper');
        return new MovimientoFieldset($almacenMapper);
    }
}