<?php
/**
 * Created by PhpStorm.
 * User: brodriguez
 * Date: 11/02/17
 * Time: 01:20 AM
 */

namespace Sample\Controller;


use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class IndexController extends AbstractActionController {

    const RECORDS_PER_PAGE = 10;
    const PAGE_RANGE = 5;

    public function indexAction() {
        return new ViewModel();
    }

    public function getStateListAction(){

        $request = $this->getRequest();

        if($request->isXmlHttpRequest()){

            $viewModel = new ViewModel();

            $page = $this->params()->fromRoute('page');
            $order = $this->params()->fromRoute('order');
            $column = $this->params()->fromRoute('column');

            $page = empty($page) ? '1' : $page;
            $order = empty($order) ? 'asc' : $order;
            $column = empty($column) ? 'state_name' : $column;

            $stateTable = $this->getServiceLocator()->get('Sample\Model\StateTable');
            $paginator = $stateTable->getStates(
                array(), array('state_id', 'state_name', 'status'), true, array("$column $order")
            );

            $paginator->setCurrentPageNumber($page)
                ->setItemCountPerPage(self::RECORDS_PER_PAGE)
                ->setPageRange(self::PAGE_RANGE);

            $stateList = json_decode($paginator->toJson());

            $viewModel->setVariables(array('stateList' => $stateList, 'paginator' => $paginator, 'conObj' => $this, 'page' => $page, 'order' => $order, 'column' => $column));

        }
        $viewModel->setTerminal(true);
        return $viewModel;
    }
}