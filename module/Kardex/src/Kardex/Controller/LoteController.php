<?php
/**
 * Created by PhpStorm.
 * User: brodriguez
 * Date: 05/04/17
 * Time: 04:40 PM
 */

namespace Kardex\Controller;


use Kardex\Form\DetallesLoteForm;
use Kardex\Form\FiltrosProductoForm;
use Kardex\Model\DetallesLoteEntity;
use Kardex\Model\LoteEntity;
use Zend\Http\Request;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\Mvc\Router\Http\RouteMatch;
use Zend\Session\Container;
use Zend\View\Model\ViewModel;

class LoteController extends AbstractActionController
{
    public function indexAction()
    {
        $loteMapper = $this->getLoteMapper();
        return new ViewModel(array(
            'lotes' =>$loteMapper->fetchAll()
        ));
    }

    public function getLoteMapper()
    {
        $sm = $this->getServiceLocator();
        return $sm->get('LoteMapper');
    }

    public function getDetallesLoteMapper()
    {
        $sm = $this->getServiceLocator();
        return $sm->get('DetallesLoteMapper');
    }

    public function detallesAction()
    {
        $page = $this->params()->fromRoute('page');
        $idlote = $this->params()->fromRoute('idlote');
        $detallesLoteMapper = $this->getDetallesLoteMapper();

        $idlote = empty($idlote) ? null : $idlote;

        $where = array();
        if ($idlote){
            $where['lote'] = $idlote;
        }

        $detallesLote = $detallesLoteMapper->getDetallesLote($where);

        return new ViewModel(array(
            'detallesLote' =>$detallesLote
        ));
    }

    public function createAction()
    {
        $tipo = $this->params()->fromRoute('tipo');
        $idlote = empty($tipo) ? 1 : $tipo;

        $this->createLote($tipo);

        return $this->redirect()->toRoute('kardex/inventario', array('controller' => 'lote','action'=>'index'));
    }

    public function createLote($tipo, $ubicacion = "")
    {
        $loteMapper = $this->getLoteMapper();
        $lastCodigo = $loteMapper->getLastCodigo($tipo);
        $codigo = $loteMapper->generateCodigo($lastCodigo,$tipo);
        $loteEntity = new LoteEntity();

        $loteEntity->setNumLote($codigo);
        $loteEntity->setTipo($tipo);
        $loteEntity->setUbicacion($ubicacion);

        $loteMapper->saveLote($loteEntity);

        $id = $loteEntity->getId();

        if (!$id) {
            $this->flashMessenger()->addErrorMessage("Ocurrio un error al tratar de crear el lote");
            return false;
        }
        $this->flashMessenger()->addSuccessMessage("El Lote ".$loteEntity->getNumLote()." fue creado correctamente");
        return true;
    }



    public function addDetallesAction()
    {
        $lote = $this->params()->fromRoute('lote');
        $producto = $this->params()->fromRoute('producto');
        $costo = $this->params()->fromRoute('costo');
        $vencimiento = $this->params()->fromRoute('vencimiento');

        $lote = empty($lote) ? null : $lote;
        $producto = empty($producto) ? null : $producto;
        $costo = empty($costo) ? null : $costo;
        $vencimiento = empty($vencimiento) ? null : $vencimiento;

        $detalles = $this->addDetailsLote($lote, $producto, $costo, $vencimiento);

        $sesion = new Container('Lote');
        $sesion->offsetUnset('idlote');
        $sesion->offsetUnset('numlote');
        $sesion->offsetUnset('idproducto');
        $sesion->offsetUnset('nombproducto');
        $sesion->offsetUnset('urlroute');
        $sesion->offsetUnset('urlcontroller');
        $sesion->offsetUnset('urlaction');
        return $this->redirect()->toRoute('kardex/inventario/wildcard', array('controller' => 'lote','action'=>'detalles', 'idlote' => $lote));

    }

    public function addDetailsLote($lote, $producto, $costo, $vencimiento)
    {
        $detallesLoteMapper = $this->getDetallesLoteMapper();
        $where  = array('lote' => $lote, 'producto' => $producto);

        $existeDetalleLote = $detallesLoteMapper->getDetallesLote($where);

        if ($existeDetalleLote) {
            $this->flashMessenger()->addErrorMessage("No se pudo agregar el producto. Ya existe en el lote");
            return false;
        }

        $detallesLote = new DetallesLoteEntity();
        $detallesLote->setLote($lote);
        $detallesLote->setProducto($producto);
        $detallesLote->setCosto($costo);
        $detallesLote->setVencimiento($vencimiento);

        $detallesLoteMapper->saveDetallesLote($detallesLote);

        $this->flashMessenger()->addSuccessMessage("El producto fue agregado con éxito al lote");
        return true;
    }

    public function newDetalleAction()
    {
        $detallesLoteForm = new DetallesLoteForm('Añadir Detalle al Lote');
        $detallesLote = new DetallesLoteEntity();
        $detallesLoteForm->bind($detallesLote);

        $sesion = new Container('Lote');
        $detallesLoteForm->get('lote')->setValue($sesion->idlote);
        $detallesLoteForm->get('numlote')->setValue($sesion->numlote);
        $detallesLoteForm->get('producto')->setValue($sesion->idproducto);
        $detallesLoteForm->get('nombproducto')->setValue($sesion->nombproducto);

        $request = $this->getRequest();

        if ($request->isPost()) {
            $detallesLoteForm->setData($request->getPost());
            if ($detallesLoteForm->isValid()) {
                $detallesLoteForm->bind($detallesLote);
                $lote = $detallesLote->getLote();
                $producto = $detallesLote->getProducto();
                $costo = $detallesLote->getCosto();
                $vencimiento = $detallesLote->getVencimiento();

                return $this->redirect()->toRoute('kardex/inventario/wildcard', array('controller' => 'lote','action'=>'add-detalles', 'lote' => $lote, 'producto' => $producto, 'costo' => $costo, 'vencimiento' => $vencimiento));
            }
        }

        return new ViewModel(array(
            'form' => $detallesLoteForm
        ));
    }

    public function selectLoteAction()
    {
        $viewmodel  = new ViewModel();

        $request = $this->getRequest();
        $referer = $request->getHeader('referer');
        $refererUri = $referer->getUri();
        $refererRequest = new Request();
        $refererRequest->setUri($refererUri);
        $serviceManager = $this->getServiceLocator();
        $routeStack = $serviceManager->get('Router');
        $match = $routeStack->match($refererRequest);
        if ($match instanceof RouteMatch) {
            $route = $match->getMatchedRouteName();
            $urlcontroller = $match->getParam('controller');
            $urlaction = $match->getParam('action');
            $sesion = new Container('Lote');
            $sesion->urlroute = $route;
            $sesion->urlcontroller = $urlcontroller;
            $sesion->urlaction = $urlaction;
        }

        $loteMapper = $this->getLoteMapper();

        //disable layout if request by Ajax
        $viewmodel->setTerminal($request->isXmlHttpRequest());

        $is_xmlhttprequest = 1;
        if (! $request->isXmlHttpRequest()) {
            //if NOT using Ajax
            $is_xmlhttprequest = 0;
        }

        $viewmodel->setVariables(array(
            'lotes' => $loteMapper->fetchAll()->toArray(),
            // is_xmlhttprequest is needed for check this form is in modal dialog or not
            // in view
            'is_xmlhttprequest' => $is_xmlhttprequest
        ));


        return $viewmodel;
    }

    public function requestLoteAction()
    {

        $idlote = $this->params()->fromRoute('idlote');
        $idlote = empty($idlote) ? null : $idlote;
        $loteMapper = $this->getLoteMapper();

        if ($idlote){
            $sesion = new Container('Lote');
            $lote = $loteMapper->getLote($idlote);
            $sesion->idlote = $lote->getId();
            $sesion->numlote = $lote->getNumLote();
            //var_dump($sesion);
            $route = $sesion->urlroute;
            $controller = $sesion->urlcontroller;
            $action = $sesion->urlaction;

            return $this->redirect()->toRoute($route, array('controller' => $controller, 'action' => $action));

        }
    }

    public function getProductoMapper()
    {
        $sm = $this->getServiceLocator();
        return $sm->get('ProductoMapper');
    }

    public function selectProductoAction()
    {
        $request = $this->getRequest();
        $referer = $request->getHeader('referer');
        $refererUri = $referer->getUri();
        $refererRequest = new Request();
        $refererRequest->setUri($refererUri);
        $serviceManager = $this->getServiceLocator();
        $routeStack = $serviceManager->get('Router');
        $match = $routeStack->match($refererRequest);
        if ($match instanceof RouteMatch) {
            $route = $match->getMatchedRouteName();
            $urlcontroller = $match->getParam('controller');
            $urlaction = $match->getParam('action');
            $sesion = new Container('Lote');
            $sesion->urlroute = $route;
            $sesion->urlcontroller = $urlcontroller;
            $sesion->urlaction = $urlaction;
        }

        $viewModel  = new ViewModel();
        $viewModel->setTerminal(true);
        return $viewModel;
    }

    public function getProductosAction()
    {
        $viewmodel  = new ViewModel();

        $request = $this->getRequest();

        //disable layout if request by Ajax
        $viewmodel->setTerminal($request->isXmlHttpRequest());

        $is_xmlhttprequest = 1;
        if (! $request->isXmlHttpRequest()) {
            //if NOT using Ajax
            $is_xmlhttprequest = 0;
        }

        if($request->isXmlHttpRequest()){

            $idmarca = $this->params()->fromRoute('marca');
            $idcategoria = $this->params()->fromRoute('categoria');

            $idmarca = ($idmarca == '0') ? null: $idmarca;
            $idcategoria = ($idcategoria == '0') ? null: $idcategoria;

            $where = array();
            if ($idmarca){
                $where['idmarca'] = $idmarca;
            }
            if ($idcategoria){
                $where['idcategoria'] = $idcategoria;
            }

            $productoMapper = $this->getProductoMapper();
            $filtrosProductoService = $this->getServiceLocator()->get('Kardex\Service\FiltrosProducto');

            $filtros = new FiltrosProductoForm($filtrosProductoService, $where);
            $filtros->get('marca')->setValue($idmarca);
            $filtros->get('categoria')->setValue($idcategoria);

            $productos = $filtrosProductoService->getProductos($idmarca, $idcategoria);

            //$inventario = json_decode($productos->toJson());

            $viewmodel->setVariables(array(
                'productos' => $productos,
                'conObj' => $this,
                'marca' => $idmarca,
                'categoria' => $idcategoria,
                'filtros' => $filtros,
                'is_xmlhttprequest' => $is_xmlhttprequest
            ));

        }
        return $viewmodel;
    }

    public function requestProductoAction()
    {

        $idproducto = $this->params()->fromRoute('idproducto');
        $idproducto = empty($idproducto) ? null : $idproducto;
        $productoMapper = $this->getProductoMapper();

        if ($idproducto){
            $sesion = new Container('Lote');
            $producto = $productoMapper->getProducto($idproducto,true);
            $sesion->idproducto = $producto->getId();
            $sesion->nombproducto = $producto->getNombre();
            //var_dump($sesion);
            $route = $sesion->urlroute;
            $controller = $sesion->urlcontroller;
            $action = $sesion->urlaction;

            return $this->redirect()->toRoute($route, array('controller' => $controller, 'action' => $action));

        }
    }

    public function filtroAction()
    {
        $request = $this->getRequest();
        $response = $this->getResponse();
        $mapper = $this->getProductoMapper();

        if ($request->isPost()) {
            $post_data = $request->getPost();
            $cat_id = $post_data['categoria'];
            $marca_id = $post_data['marca'];

            if ($productos = $mapper->getProductosFiltro($cat_id, $marca_id)) {
                $arreglo = $productos->toArray();
                $response->setContent(\Zend\Json\Json::encode(array('response' => true, 'productos' => $arreglo)));
            } else {
                $response->setContent(\Zend\Json\Json::encode(array('response' => false)));
            }


            return $response;
        }
    }

    public function editDetalleAction()
    {
        $id = $this->params()->fromRoute('id');
        $id = empty($id) ? null : $id;

        $detallesLoteMapper = $this->getDetallesLoteMapper();
        $where  = array('id' => $id);

        $existeDetalleLote = $detallesLoteMapper->getDetallesLoteById($where);

        if (!$existeDetalleLote) {
            $this->flashMessenger()->addErrorMessage("No existe este detalle en el lote especificado");
            return false;
        }

        $detallesLoteForm = new DetallesLoteForm('Editar Detalle de Lote');

        $detallesLoteForm->bind($existeDetalleLote);
        $detallesLoteForm->get('numlote')->setValue($existeDetalleLote->getNumLote());
        //$detallesLoteForm->get('numlote')->setAttribute('readonly',true);
        //$detallesLoteForm->get('numlote')->setAttribute('disabled',true);
        $detallesLoteForm->get('numlote')->setAttributes(array('readonly' => true, 'disabled' => true));
        $detallesLoteForm->get('nombproducto')->setValue($existeDetalleLote->getNombProducto());
        //$detallesLoteForm->get('nombproducto')->setAttribute('readonly',true);
        //$detallesLoteForm->get('nombproducto')->setAttribute('disabled',true);
        $detallesLoteForm->get('nombproducto')->setAttributes(array('readonly' => true, 'disabled' => true));

        $request = $this->getRequest();

        if ($request->isPost()) {
            $detallesLoteForm->setData($request->getPost());
            if ($detallesLoteForm->isValid()) {
                $detallesLoteForm->bind($existeDetalleLote);
                $lote = $existeDetalleLote->getLote();

                $detallesLoteMapper->saveDetallesLote($existeDetalleLote);

                $this->flashMessenger()->addSuccessMessage("El producto fue agregado con éxito al lote");

                return $this->redirect()->toRoute('kardex/inventario/wildcard', array('controller' => 'lote','action'=>'detalles', 'idlote' => $lote));
            }
        }

        return new ViewModel(array(
            'form' => $detallesLoteForm
        ));
    }

}