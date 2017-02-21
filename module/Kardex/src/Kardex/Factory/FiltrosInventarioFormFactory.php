<?php
/**
 * Created by PhpStorm.
 * User: brodriguez
 * Date: 17/02/17
 * Time: 05:26 PM
 */

namespace Kardex\Factory;


use Kardex\Form\FiltrosInventarioForm;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class FiltrosInventarioFormFactory implements FactoryInterface
{
    protected $options = array();
    protected $inventarioService;
    protected $where = array();

    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $serviceLocator = $sm->getServiceLocator();
        $inventarioService = $serviceLocator->get('Kardex\Service\Inventario');
        $options = $this->where;
        return new FiltrosInventarioForm($inventarioService);
    }

    function __construct($where = array())
    {
        $this->where = $where;
    }

}