<?php
/**
 * Created by PhpStorm.
 * User: brodriguez
 * Date: 12/04/17
 * Time: 10:44 AM
 */

namespace Kardex\Service;


use Zend\ServiceManager\ServiceLocatorAwareInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class FiltrosProductoService implements ServiceLocatorAwareInterface
{
    protected $serviceLocator;

    public function setServiceLocator(ServiceLocatorInterface $serviceLocator)
    {
        $this->serviceLocator = $serviceLocator;
    }

    public function getServiceLocator()
    {
        return $this->serviceLocator;
    }

    public function getProductoMapper()
    {
        return  $this->getServiceLocator()->get('ProductoMapper');
    }

    public function getProductos($idmarca = null, $idcategoria = null)
    {
        $filtrosProductoMapper = $this->getServiceLocator()->get('FiltrosProductoMapper');
        $where = array();
        if(!is_null($idmarca)) {
            $where['idmarca'] = $idmarca;
        }
        if(!is_null($idcategoria)) {
            $where['idcategoria'] = $idcategoria;
        }

        $productos = $filtrosProductoMapper->getProductos($where, false);

        return $productos;
    }

    public function getMarcasDisponibles($idcategoria = null)
    {
        $filtrosProductoMapper = $this->getServiceLocator()->get('FiltrosProductoMapper');
        $where = array();
        if(!is_null($idcategoria)) {
            $where['idcategoria'] = $idcategoria;
        }
        $marcas = $filtrosProductoMapper->getMarcasDisponibles($where);
        return $marcas;
    }

    public function getCategoriasDisponibles($idmarca = null)
    {
        $filtrosProductoMapper = $this->getServiceLocator()->get('FiltrosProductoMapper');
        $where = array();
        if(!is_null($idmarca)) {
            $where['idmarca'] = $idmarca;
        }
        $categorias = $filtrosProductoMapper->getCategoriasDisponibles($where);
        return $categorias;
    }

}