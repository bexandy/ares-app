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
use Almacen\Model\SolicitudProductoEntity;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class MermaController extends AbstractActionController
{
    protected $eventManager;

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
                $productos = $productoMapper->fetchAll(true,true);
                $productos->setCurrentPageNumber((int) $this->params()->fromQuery('page', 1));
                $productos->setItemCountPerPage(18);
            } else {
                $productos = $productoMapper->getProductosMarca($idmarc,true,true);
                $productos->setCurrentPageNumber((int) $this->params()->fromQuery('page', 1));
                $productos->setItemCountPerPage(18);
            }

        } else {
            $productos = $productoMapper->fetchAll(true,true);
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
        $producto = $this->getProductoMapper()->getProducto($id,false);
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

                        $solicitud = new SolicitudProductoEntity();
                        $solicitud->setIdproducto($id);
                        $solicitud->setEstatus(1);
                        $solicitud->setFecha(date('Y-m-d'));
                        $this->getSolicitudProductoMapper()->saveSolicitud($solicitud);

                        // Enviamos un mensaje flash al usuario
                        $this->flashMessenger()->addMessage('¡Usted ha notificado con éxito a la administración que el producto '.$producto->getNombre().'se ha agotado en tienda!');
                        // Disparamos un evento 'nuevaSolicitudEvent'
                        $this->getEventManager()->trigger('nuevaSolicitudEvent', $this ,array());
                        return $this->redirect()->toRoute('despacho');
                    }

                } else {
                    $this->flashMessenger()->addErrorMessage('¡Hubo un error al tratar de notificar que el producto se ha agotado (El sistema no encuentra el producto '.$producto->getNombre().' disponible en almacén)! Inténtelo de nuevo');
                    return $this->redirect()->toRoute('agotado');
                }
            }

            return $this->redirect()->toRoute('agotado', array('action'=>'solicitar-producto', 'id' => $id));
        }

        return array(
            'id' => $id,
            'producto' => $producto
        );
    }

    public function solicitarProductoAction()
    {
        $id = $this->params('id');
        $producto = $this->getProductoMapper()->getProducto($id,true);
        if ($producto->getDisponible() === '1') {
            $agotado = false;
        } else {
            $agotado = true;
        }

        $request = $this->getRequest();
        if ($request->isPost()) {
            if ($request->getPost()->get('solicitar') == 'Solicitar Producto') {
                $existeSolicitud = $this->getSolicitudProductoMapper()->existeSolicitud($producto->getId());
                if (! $existeSolicitud ){
                    $solicitud = new SolicitudProductoEntity();
                    $solicitud->setIdproducto($id);
                    $solicitud->setEstatus(1);
                    $solicitud->setFecha(date('Y-m-d'));
                    $this->getSolicitudProductoMapper()->saveSolicitud($solicitud);

                    $this->flashMessenger()->addMessage('¡Usted ha solicitado  con éxito el producto '.$producto->getNombre().' a la administración!');

                    // Disparamos un evento 'nuevaSolicitudEvent'
                    $this->getEventManager()->trigger('nuevaSolicitudEvent', $this ,array());
                    return $this->redirect()->toRoute('despacho');
                } else {
                    $this->flashMessenger()->addErrorMessage('No se pudo realizar la solicitud, ¡El producto '.$producto->getNombre().' ya fué solicitado con anterioridad!');
                    return $this->redirect()->toRoute('agotado');
                }

            }
            $this->flashMessenger()->addErrorMessage('¡Hubo un error al tratar de realizar la operación! No se ha utilizado el método adecuado');
            return $this->redirect()->toRoute('despacho');
        }

        return array(
            'id' => $id,
            'producto' => $producto,
            'agotado' => $agotado
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

    public function getSolicitudProductoMapper()
    {
        $sm = $this->getServiceLocator();
        return $sm->get('SolicitudProductoMapper');
    }

    public function getMensajesMapper()
    {
        $sm = $this->getServiceLocator();
        return $sm->get('MensajesMapper');
    }

    public function listadoSolicitudesAction()
    {
        $solicitudes = $this->getSolicitudProductoMapper()->getSolicitudesActivas();
        return new ViewModel(array(
            'solicitudes' => $solicitudes
        ));
    }
}