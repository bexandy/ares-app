<?php
/**
 * Created by PhpStorm.
 * User: brodriguez
 * Date: 11/02/17
 * Time: 12:01 AM
 */

namespace TestAjax\Controller;


use Zend\Json\Json;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\Paginator\Adapter\ArrayAdapter;
use Zend\Paginator\Paginator;
use Zend\View\Model\ViewModel;

class CustomersController extends AbstractActionController
{
    public function listAction()
    {
        $variables = array();
        $view = new ViewModel();

        // SET LAS VARIABLES NECESARIAS PARA EL TEMPLATE VIEW
        $view->setVariables($variables);

        // SET EL TEMPLATE VIEW
        $view->setTemplate('customers/list');

        return $view;
    }

    public function pagerAction()
    {
        // POST DATA
        $data = get_object_vars($this->getRequest()->getPost());

        // GET DATA FROM THE DATABASE
        $customers = $this->getIngresoMapper()->getDisponibilidadAlmacen(1);

        // INITIALIZE THE PAGINATOR IN CASE THE DATABASE RETURNS ROWS
        if(is_array($customers)){
            $paginator = new Paginator(new ArrayAdapter($customers));
        }else{
            $paginator = $customers;
        }
        $paginator->setItemCountPerPage(100);

        //SET THE PAGE NUMBER FROM THE ROUTE
        $paginator->setCurrentPageNumber(
            $this->getEvent()->getRouteMatch()->getParam('page',1)
        );

        // CREATE THE VIEW
        $view = new ViewModel();

        // SET THE VARIABLES NEEDED BY THE TEMPLATE VIEW
        $view->setVariables(
            array(
                'customers' => $paginator
            )
        );

        // SET THE TEMPLATE VIEW (THE TEMPLATE IS THE ONE DEFINED IN module.config.php)
        $view->setTemplate('customers-content');

        $viewHTML = $this->getServiceLocator()->get('viewrenderer')->render($view);

        //THAT'S THE INFORMATION THA'LL BE RETURNED BACK TO THE CLIENT
        $result = array(
            'success' => true,
            'HTML' => $viewHTML
        );

        // PREPARE THE RESPONSE WITH THE ARRAY CONVERTED TO A JSON OBJECT
        $this->response->setContent(Json::encode($result));

        //RETURN THE RESPONSE
        return $this->response;
    }

    public function getIngresoMapper()
    {
        $sm = $this->getServiceLocator();
        return $sm->get('IngresoMapper');
    }

}