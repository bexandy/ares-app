<?php
/**
 * Created by PhpStorm.
 * User: brodriguez
 * Date: 12/02/17
 * Time: 01:27 PM
 */

namespace Kardex\Controller;

use Kardex\Form\FiltrosInventarioForm;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\ServiceManager\ServiceLocatorInterface;
use Zend\View\Model\ViewModel;

class InventarioController extends AbstractActionController
{
    const RECORDS_PER_PAGE = 10;
    const PAGE_RANGE = 5;
    protected $serviceLocator;

    public function indexAction()
    {

        return new ViewModel(array(

        ));
    }

    public function getInventarioListAction(){

        $request = $this->getRequest();

        $viewModel = new ViewModel();
        if($request->isXmlHttpRequest()){


            $page = $this->params()->fromRoute('page');
            $idmarca = $this->params()->fromRoute('marca');
            $idcategoria = $this->params()->fromRoute('categoria');
            $idalmacen = $this->params()->fromRoute('almacen');

            $page = empty($page) ? '1' : $page;
            $idmarca = ($idmarca == '0') ? null: $idmarca;
            $idcategoria = ($idcategoria == '0') ? null: $idcategoria;
            $idalmacen = ($idalmacen == '0') ? null: $idalmacen;

            $where = array();
            if ($idalmacen){
                $where['idalmacen'] = $idalmacen;
            }
            if ($idmarca){
                $where['idmarca'] = $idmarca;
            }
            if ($idcategoria){
                $where['idcategoria'] = $idcategoria;
            }

            /*
            $formManager = $this->serviceLocator->get('FormElementManager');
            $filtros = $formManager->get('Kardex\Form\FiltrosInventarioForm',$where);
            $filtros->get('marca')->setValue($idmarca);
            */
            $kardexService = $this->getServiceLocator()->get('Kardex\Service\InventarioService');

            $filtros = new FiltrosInventarioForm($kardexService,$where);
            $filtros->get('marca')->setValue($idmarca);
            $filtros->get('categoria')->setValue($idcategoria);
            $filtros->get('almacen')->setValue($idalmacen);

            $paginator = $kardexService->getInventario($idmarca, $idcategoria, $idalmacen);

            $paginator->setCurrentPageNumber($page)
                ->setItemCountPerPage(self::RECORDS_PER_PAGE)
                ->setPageRange(self::PAGE_RANGE);

            $inventario = json_decode($paginator->toJson());

            $viewModel->setVariables(array(
                'inventario' => $inventario,
                'paginator' => $paginator,
                'conObj' => $this,
                'page' => $page,
                'almacen' => $idalmacen,
                'marca' => $idmarca,
                'categoria' => $idcategoria,
                'filtros' => $filtros
            ));

        }else{
            $this->flashMessenger()->addErrorMessage('La solicitud debe realizarse por AJAX');
            return $this->redirect()->toRoute('kardex/inventario',array('controller' => 'Inventario', 'action' => 'index'));
        }

        $viewModel->setTerminal(true);
        return $viewModel;
    }

}