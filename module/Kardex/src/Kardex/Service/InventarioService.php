<?php
/**
 * Created by PhpStorm.
 * User: brodriguez
 * Date: 12/02/17
 * Time: 01:28 PM
 */

namespace Kardex\Service;


use Zend\ServiceManager\ServiceLocatorAwareInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class InventarioService implements ServiceLocatorAwareInterface
{
    protected $serviceLocator;

    public function getInventario($idmarca = null, $idcategoria = null, $idalmacen = null)
    {
        $inventarioMapper = $this->getServiceLocator()->get('InventarioMapper');
        $where = array();
        if(!is_null($idmarca)) {
            $where['idmarca'] = $idmarca;
        }
        if(!is_null($idcategoria)) {
            $where['idcategoria'] = $idcategoria;
        }
        if(!is_null($idalmacen)) {
            $where['idalmacen'] = $idalmacen;
        }

        $inventario = $inventarioMapper->getInventario($where, true);
        return $inventario;

    }

    public function setServiceLocator(ServiceLocatorInterface $serviceLocator)
    {
        $this->serviceLocator = $serviceLocator;
    }

    public function getServiceLocator()
    {
        return $this->serviceLocator;
    }

    public function getMarcasDisponibles($idalmacen = null, $idcategoria = null)
    {
        $inventarioMapper = $this->getServiceLocator()->get('InventarioMapper');
        $where = array();
        if(!is_null($idalmacen)) {
            $where['idalmacen'] = $idalmacen;
        }
        if(!is_null($idcategoria)) {
            $where['idcategoria'] = $idcategoria;
        }
        $inventario = $inventarioMapper->getMarcasDisponibles($where);
        return $inventario;
    }

    public function getCategoriasDisponibles($idalmacen = null, $idmarca = null)
    {
        $inventarioMapper = $this->getServiceLocator()->get('InventarioMapper');
        $where = array();
        if(!is_null($idalmacen)) {
            $where['idalmacen'] = $idalmacen;
        }
        if(!is_null($idmarca)) {
            $where['idmarca'] = $idmarca;
        }
        $inventario = $inventarioMapper->getCategoriasDisponibles($where);
        return $inventario;
    }

    public function getAlmacenDisponibles($idmarca = null, $idcategoria = null)
    {
        $inventarioMapper = $this->getServiceLocator()->get('InventarioMapper');
        $where = array();
        if(!is_null($idmarca)) {
            $where['idmarca'] = $idmarca;
        }
        if(!is_null($idcategoria)) {
            $where['idcategoria'] = $idcategoria;
        }
        $inventario = $inventarioMapper->getAlmacenDisponibles($where);
        return $inventario;
    }
}