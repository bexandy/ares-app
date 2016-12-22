<?php
/**
 * Created by PhpStorm.
 * User: brodriguez
 * Date: 03/10/16
 * Time: 03:49 PM
 */

namespace Almacen\Controller;


use Almacen\Model\DisponibilidadProductoEntity;
use Almacen\Model\MermaEntity;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class MermaController extends AbstractActionController
{
    public function indexAction()
    {
        $marcas = $this->getMarcaMapper()->getDisponibles();
        $productoMapper = $this->getProductoMapper();

        $request = $this->getRequest();
        if ($request->isPost()) {
            $selmarca = $request->getPost()->get('selmarca');
            $marc = str_replace(" ", "_", $selmarca);
            $idmarc = $request->getPost()->get($marc);

            if ($idmarc === "0") {
                $productos = $productoMapper->fetchAll(false,true);
                $productos->setCurrentPageNumber((int) $this->params()->fromQuery('page', 1));
                $productos->setItemCountPerPage(18);
            } else {
                $productos = $productoMapper->getProductosMarca($idmarc,false,true);
                $productos->setCurrentPageNumber((int) $this->params()->fromQuery('page', 1));
                $productos->setItemCountPerPage(18);
            }

        } else {
            $productos = $productoMapper->fetchAll(false,true);
            $productos->setCurrentPageNumber((int) $this->params()->fromQuery('page', 1));
            $productos->setItemCountPerPage(18);
        }

        return new ViewModel(array(
            'marcas' => $marcas,
            'productos' => $productos
        ));
    }

    public function getProductoMapper()
    {
        $sm = $this->getServiceLocator();
        return $sm->get('ProductoMapper');
    }

    public function getMarcaMapper()
    {
        $sm = $this->getServiceLocator();
        return $sm->get('MarcaMapper');
    }

    public function notificarAction()
    {
        $id = $this->params('id');
        $producto = $this->getProductoMapper()->getProducto($id);
        if (!$producto) {
            return $this->redirect()->toRoute('agotado');
        }

        $request = $this->getRequest();
        if ($request->isPost()) {
            if ($request->getPost()->get('notificar') == 'Si') {
                $disponibilidadAlmacen = $this->getIngresoMapper()->existeRegistro('2',$id);

                if ($disponibilidadAlmacen) {
                    $cantAnterior = $disponibilidadAlmacen->getCantidad();
                    if ($cantAnterior > 0){
                        $disponibilidadAlmacen->setCantidad(0);
                        $this->getIngresoMapper()->actualizarDisponibilidadAlmacen($disponibilidadAlmacen);

                        $merma = new MermaEntity();
                        $merma->setIdproducto($id);
                        $merma->setIdalmacen(2);
                        $merma->setCantidad($cantAnterior);
                        $merma->setFecha(date('Y-m-d'));
                        $this->getMermaMapper()->saveMerma($merma);

                        $disponibilidadProducto = new DisponibilidadProductoEntity();
                        $disponibilidadProducto->setIdproducto($id) ;
                        $disponibilidadProducto->setDisponible(false);
                        $this->getDisponibilidadMapper()->actualizarProducto($disponibilidadProducto);

                    }

                } else {
                    return $this->redirect()->toRoute('agotado');
                }
            }

            return $this->redirect()->toRoute('despacho');
        }

        return array(
            'id' => $id,
            'producto' => $producto
        );
    }

    public function getIngresoMapper()
    {
        $sm = $this->getServiceLocator();
        return $sm->get('IngresoMapper');
    }

    public function getMermaMapper()
    {
        $sm = $this->getServiceLocator();
        return $sm->get('MermaMapper');
    }

    public function getDisponibilidadMapper()
    {
        $sm = $this->getServiceLocator();
        return $sm->get('DisponibilidadMapper');
    }
}