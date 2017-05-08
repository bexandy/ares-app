<?php
/**
 * Created by PhpStorm.
 * User: brodriguez
 * Date: 26/04/17
 * Time: 10:25 AM
 */

namespace Kardex\Controller;


use Kardex\Form\IngresoForm;
use Kardex\Form\MovimientoIngresoForm;
use Kardex\Model\IngresoEntity;
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
        $ingresoEntity = new IngresoEntity();

        $ingresoEntity->setCodigo($codigo);
        $ingresoEntity->setTipodoc(self::INGRESO);

        $ingresoForm->bind($ingresoEntity);

        $request = $this->getRequest();

        if ($request->isPost()){
            $ingresoForm->setData($request->getPost());
            if ($ingresoForm->isValid()){
                $ingresoForm->bind($ingresoEntity);

                $this->flashMessenger()->addSuccessMessage("El Ingreso ".$ingresoEntity->getCodigo()." fue creado correctamente");
                return $this->redirect()->toRoute('kardex/inventario/wildcard', array('controller' => 'ingreso','action'=>'index'));
            }
        }

        return new ViewModel(array(
            'form' => $ingresoForm
        ));
    }


}