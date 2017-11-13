<?php
/**
 * Created by PhpStorm.
 * User: brodriguez
 * Date: 26/04/17
 * Time: 10:25 AM
 */

namespace Kardex\Controller;


use Kardex\Form\FiltrosProductoForm;
use Kardex\Form\IngresoForm;
use Kardex\Form\MovimientoIngresoForm;
use Kardex\Model\DetallesLoteEntity;
use Kardex\Model\IngresoEntity;
use Kardex\Model\MovimientoIngresoEntity;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class IngresoController extends AbstractActionController
{
    const INGRESO = 7;
    const ENTRADA = 1;
    const SALIDA = 2;

    public function indexAction()
    {
        $ingresoMapper = $this->getIngresoMapper();
        return new ViewModel(array(
            'ingresos' => $ingresoMapper->fetchAll()
        ));
    }

    public function getIngresoMapper()
    {
        $sm = $this->getServiceLocator();
        return $sm->get('IngresoMapper');
    }

    public function getDocumentoMapper()
    {
        $sm = $this->getServiceLocator();
        return $sm->get('DocumentoMapper');
    }

    public function getAlmacenMapper()
    {
        $sm = $this->getServiceLocator();
        return $sm->get('AlmacenMapper');
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

    public function getProductoMapper()
    {
        $sm = $this->getServiceLocator();
        return $sm->get('ProductoMapper');
    }

    public function createIngreso()
    {
        $ingresoMapper = $this->getIngresoMapper();
        $lastCodigo = $ingresoMapper->getLastCodigo();
        $codigo = $this->generateCodigo($lastCodigo);
        $ingresoEntity = new IngresoEntity();

        $ingresoEntity->setId($this->getDocumentoMapper()->crearNuevo(self::INGRESO));
        $ingresoEntity->setCodigo($codigo);
        $ingresoEntity->setTipodoc(self::INGRESO);
        /*
        $ingresoEntity->setDescripcion($ubicacion);

        $loteMapper->saveLote($loteEntity);
        $id = $loteEntity->getId();

        if (!$id) {
            $this->flashMessenger()->addErrorMessage("Ocurrio un error al tratar de crear el lote");
            return false;
        }
        $this->flashMessenger()->addSuccessMessage("El Lote ".$loteEntity->getNumLote()." fue creado correctamente");
        */
        return true;
    }

    public function generateCodigo($ultimoCodigo)
    {
        $prefijo = "ING";

        $ultimaSecuencia = substr($ultimoCodigo,-8);
        if (($ultimaSecuencia == 00000000) || ($ultimaSecuencia === 99999999)){
            $nuevoCodigo = (string) $prefijo.date('Ymd').'-00000001';
            return $nuevoCodigo;
        } else {
            //$ultimaSecuencia = substr($ultimoCodigo,-8);
            $nuevaSecuencia =  (int) $ultimaSecuencia + 1;
            $nuevoCodigo = $prefijo.date('Ymd').'-'.str_pad($nuevaSecuencia,8,'0',STR_PAD_LEFT);
            return $nuevoCodigo;
        }
    }

    public function nuevoAction()
    {
        $ingresoMapper = $this->getIngresoMapper();
        $lastCodigo = $ingresoMapper->getLastCodigo();
        $codigo = $this->generateCodigo($lastCodigo);

        $ingresoForm = new IngresoForm("Nuevo Ingreso");
        $ingresoEntity = new IngresoEntity();

        $ingresoEntity->setCodigo($codigo);
        $ingresoEntity->setTipodoc(self::INGRESO);

        $ingresoForm->bind($ingresoEntity);

        $request = $this->getRequest();

        if ($request->isPost()){
            $ingresoForm->setData($request->getPost());
            if ($ingresoForm->isValid()){
                $ingresoForm->bind($ingresoEntity);
                $ingresoEntity->setId($this->getDocumentoMapper()->crearNuevo(self::INGRESO));

                $ingresoMapper->insertIngreso($ingresoEntity);

                $this->flashMessenger()->addSuccessMessage("El Ingreso ".$ingresoEntity->getCodigo()." fue creado correctamente");
                return $this->redirect()->toRoute('kardex/inventario/wildcard', array('controller' => 'ingreso','action'=>'index'));
            }
        }

        return new ViewModel(array(
            'form' => $ingresoForm
        ));
    }

    public function movimientoAction()
    {
        $ingresoMapper = $this->getIngresoMapper();
        $lastCodigo = $ingresoMapper->getLastCodigo();
        $codigo = $this->generateCodigo($lastCodigo);
        $almacenMapper = $this->getAlmacenMapper();

        $ingresoForm = new MovimientoIngresoForm($almacenMapper,"Crear Ingreso");
        $movimientoIngresoEntity = new MovimientoIngresoEntity();

        $ingresoEntity = new IngresoEntity();
        $ingresoEntity->setCodigo($codigo);
        $ingresoEntity->setTipodoc(self::INGRESO);

        $movimientoIngresoEntity->setIngreso($ingresoEntity);

        $ingresoForm->bind($movimientoIngresoEntity);

        $request = $this->getRequest();

        if ($request->isPost()){
            $ingresoForm->setData($request->getPost());
            if ($ingresoForm->isValid()){
                /*
                $ingresoForm->bind($movimientoIngresoEntity);

                $movimientoEntity = new MovimientoEntity();
                $ingresoForm->bind($movimientoEntity);

                $detalles = new DetallesLoteEntity();
                $ingresoForm->bind($detalles);
                $ingresoForm->
                */
                var_dump($movimientoIngresoEntity);

                    /*
                $this->flashMessenger()->addSuccessMessage("El Ingreso ".$ingresoEntity->getCodigo()." fue creado correctamente");
                return $this->redirect()->toRoute('kardex/inventario/wildcard', array('controller' => 'ingreso','action'=>'index'));
            */
                    }
        }

        return new ViewModel(array(
            'form' => $ingresoForm
        ));
    }

    public function selectLoteAction()
    {

        $viewmodel  = new ViewModel();
        $item = $_POST['iditem'];
        $almacen = $_POST['almacen'];

        $almacen = ($almacen == '0' || $almacen == "") ? null: $almacen;

        if ($almacen){
            $where = array('tipo' => $almacen);
        } else {
            $where = array();
        }


        $request = $this->getRequest();
        $loteMapper = $this->getLoteMapper();

        //disable layout if request by Ajax
        $viewmodel->setTerminal($request->isXmlHttpRequest());

        $is_xmlhttprequest = 1;
        if (! $request->isXmlHttpRequest()) {
            //if NOT using Ajax
            $is_xmlhttprequest = 0;
        }

        $viewmodel->setVariables(array(
            'lotes' => $loteMapper->getLotesBy($where)->toArray(),
            'item' => $item,
            // is_xmlhttprequest is needed for check this form is in modal dialog or not
            // in view
            'is_xmlhttprequest' => $is_xmlhttprequest
        ));


        return $viewmodel;
    }

    public function validarLoteAction()
    {
        $request = $this->getRequest();
        $response   = $this->getResponse();
        $is_xmlhttprequest = 1;
        if (! $request->isXmlHttpRequest()) {
            $is_xmlhttprequest = 0;
        }
        if ($request->isPost()){
            $idlote = $_POST['lote'];
            $idproducto = $_POST['producto'];
            $idalmacen = $_POST['almacen'];
            $idlote = ($idlote == '0' || $idlote == "") ? null: $idlote;
            $idproducto = ($idproducto == '0' || $idproducto == "") ? null: $idproducto;
            $idalmacen = ($idalmacen == '0' || $idalmacen == "") ? null: $idalmacen;

            $almacen = $this->getAlmacenMapper()->getAlmacen($idalmacen);

            if ($almacen) {
                $tipoAlmacen = $almacen->getNombtipoalmacen();
            } else {
                $response->setContent(\Zend\Json\Json::encode(array('error' => true, 'mensaje' => 'ID de Almacén No Encontrado')));
                return $response;
            }

            if ($idproducto){
                $existeLote = $this->getLoteMapper()->getLote($idlote);

                if ($existeLote) {
                    $detallesLoteMapper = $this->getDetallesLoteMapper();
                    $where  = array('lote' => $idlote, 'producto' => $idproducto);

                    $existeDetalleLote = $detallesLoteMapper->getDetallesLote($where);

                    if ($existeDetalleLote) {
                        $response->setContent(\Zend\Json\Json::encode(array('error' => false, 'existeDetalle' => true, 'hayProducto' => true, 'detalle' => $existeDetalleLote, 'almacen' => $tipoAlmacen)));
                    } else {
                        $productoEntity = $this->getProductoMapper()->getProducto($idproducto, true);
                        $producto = $productoEntity->toArray();
                        if ($producto)
                            $response->setContent(\Zend\Json\Json::encode(array('error' => false, 'existeDetalle' => false, 'hayProducto' => true, 'producto' => $producto, 'almacen' => $tipoAlmacen)));
                        else
                            $response->setContent(\Zend\Json\Json::encode(array('error' => true, 'mensaje' => 'ID de Producto No Encontrado')));                    }
                } else {
                    $productoEntity = $this->getProductoMapper()->getProducto($idproducto, true);
                    $producto = $productoEntity->toArray();
                    if ($producto)
                        $response->setContent(\Zend\Json\Json::encode(array('error' => false, 'existeDetalle' => false, 'hayProducto' => true, 'producto' => $producto, 'almacen' => $tipoAlmacen)));
                    else
                        $response->setContent(\Zend\Json\Json::encode(array('error' => true, 'mensaje' => 'ID de Producto No Encontrado')));
                }
            } else {
                $response->setContent(\Zend\Json\Json::encode(array('error' => false, 'hayProducto' => false)));
                return $response;
            }
        }
        return $response;
    }

    public function selectProductoAction()
    {
        $viewModel  = new ViewModel();
        $item = $_POST['iditem'];
        $viewModel->setTerminal(true);
        $viewModel->setVariables(array(
            'item' => $item,
        ));
        return $viewModel;
    }

    public function getProductoAction()
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

            $idmarca = $_POST['marca'];
            $idcategoria = $_POST['categoria'];

            $idmarca = ($idmarca == '0' || $idmarca == "") ? null: $idmarca;
            $idcategoria = ($idcategoria == '0' || $idcategoria == "") ? null: $idcategoria;

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
                'marca' => $idmarca,
                'categoria' => $idcategoria,
                'filtros' => $filtros,
                'is_xmlhttprequest' => $is_xmlhttprequest
            ));

        }
        return $viewmodel;
    }

    public function validarProductoAction()
    {
        $request = $this->getRequest();
        $response   = $this->getResponse();

        $is_xmlhttprequest = 1;
        if (! $request->isXmlHttpRequest()) {
            $is_xmlhttprequest = 0;
        }
        if ($request->isPost()){
            $idlote = $_POST['lote'];
            $idproducto = $_POST['producto'];
            $idalmacen = $_POST['almacen'];
            $idlote = ($idlote == '0' || $idlote == "") ? null: $idlote;
            $idproducto = ($idproducto == '0' || $idproducto == "") ? null: $idproducto;
            $idalmacen = ($idalmacen == '0' || $idalmacen == "") ? null: $idalmacen;

            $almacen = $this->getAlmacenMapper()->getAlmacen($idalmacen);

            if ($almacen) {
                $tipoAlmacen = $almacen->getNombtipoalmacen();
            } else {
                $response->setContent(\Zend\Json\Json::encode(array('error' => true, 'mensaje' => 'ID de Almacén No Encontrado')));
                return $response;
            }


            $existeLote = $this->getLoteMapper()->getLote($idlote);

            if ($existeLote) {
                $detallesLoteMapper = $this->getDetallesLoteMapper();
                $where  = array('lote' => $idlote, 'producto' => $idproducto);

                $existeDetalleLote = $detallesLoteMapper->getDetallesLote($where);

                if ($existeDetalleLote) {
                    $response->setContent(\Zend\Json\Json::encode(array('error' => false, 'hayLote' => true, 'existeDetalle' => true, 'detalle' => $existeDetalleLote, 'almacen' => $tipoAlmacen)));
                } else {
                    $productoEntity = $this->getProductoMapper()->getProducto($idproducto, true);
                    $producto = $productoEntity->toArray();
                    if ($producto)
                        $response->setContent(\Zend\Json\Json::encode(array('error' => false, 'hayLote' => true, 'existeDetalle' => false, 'producto' => $producto, 'almacen' => $tipoAlmacen)));
                    else
                        $response->setContent(\Zend\Json\Json::encode(array('error' => true, 'mensaje' => 'ID de Producto No Encontrado')));                    }
            } else {
                $productoEntity = $this->getProductoMapper()->getProducto($idproducto, true);
                $producto = $productoEntity->toArray();
                if ($producto)
                    $response->setContent(\Zend\Json\Json::encode(array('error' => false, 'hayLote' => false, 'existeDetalle' => false, 'producto' => $producto, 'almacen' => $tipoAlmacen)));
                else
                    $response->setContent(\Zend\Json\Json::encode(array('error' => true, 'mensaje' => 'ID de Producto No Encontrado')));
            }


        }

        return $response;
    }

    public function selectUMAction()
    {
        $mapper = $this->getUnidadMedidaMapper();
        $viewModel  = new ViewModel();
        $item = $_POST['iditem'];
        $viewModel->setTerminal(true);
        $viewModel->setVariables(array(
            'item' => $item,
            'unidadesMedida' => $mapper->fetchAll()
        ));
        return $viewModel;
    }

    public function getUnidadMedidaMapper()
    {
        $sm = $this->getServiceLocator();
        return $sm->get('UnidadMedidaMapper');
    }

    public function nuevoLoteAction()
    {
        $request = $this->getRequest();
        $response   = $this->getResponse();

        if ($request->isPost()){
            $idalmacen = $_POST['almacen'];
            $idalmacen = ($idalmacen == '0' || $idalmacen == "") ? null: $idalmacen;

            $almacen = $this->getAlmacenMapper()->getAlmacen($idalmacen);

            if ($almacen) {
                $tipo = $almacen->getIdtipoalmacen();
            } else {
                $response->setContent(\Zend\Json\Json::encode(array('error' => true, 'mensaje' => 'ID de Almacén No Encontrado')));
                return $response;
            }
            $loteMapper = $this->getLoteMapper();
            $lastCodigo = $loteMapper->getLastCodigo($tipo);
            $codigo = $loteMapper->generateCodigo($lastCodigo,$tipo);
            $response->setContent(\Zend\Json\Json::encode(array('error' => false, 'numlote' => $codigo)));
        }
        return $response;
    }

    public function selectDefaultLoteAction()
    {
        $viewmodel  = new ViewModel();
        $almacen = $_POST['almacen'];
        $almacen = ($almacen == '0' || $almacen == "") ? null: $almacen;

        if ($almacen){
            $where = array('tipo' => $almacen);
        } else {
            $where = array();
        }

        $request = $this->getRequest();
        $loteMapper = $this->getLoteMapper();

        $is_xmlhttprequest = 1;
        if (! $request->isXmlHttpRequest()) {
            $is_xmlhttprequest = 0;
        }
        $viewmodel->setTerminal($request->isXmlHttpRequest());
        $viewmodel->setVariables(array(
            'lotes' => $loteMapper->getLotesBy($where)->toArray(),
            'is_xmlhttprequest' => $is_xmlhttprequest
        ));

        return $viewmodel;
    }


}