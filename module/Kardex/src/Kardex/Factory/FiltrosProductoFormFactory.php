<?php
/**
 * Created by PhpStorm.
 * User: brodriguez
 * Date: 17/04/17
 * Time: 12:57 PM
 */

namespace Kardex\Factory;


use Kardex\Form\FiltrosProductoForm;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class FiltrosProductoFormFactory implements FactoryInterface
{
    protected $options = array();
    protected $filtrosProductoService;
    protected $where = array();

    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $serviceLocator = $sm->getServiceLocator();
        $filtrosProductoService = $serviceLocator->get('Kardex\Service\FiltrosProducto');
        $options = $this->where;
        return new FiltrosProductoForm($filtrosProductoService, $options);
    }

    function __construct($where = array())
    {
        $this->where = $where;
    }

}