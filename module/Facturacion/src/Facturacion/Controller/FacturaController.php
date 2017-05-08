<?php
/**
 * Created by PhpStorm.
 * User: brodriguez
 * Date: 23/02/17
 * Time: 08:57 AM
 */

namespace Facturacion\Controller;


use Facturacion\Form\FacturaForm;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class FacturaController extends AbstractActionController
{
    public function indexAction()

    {
        $form = new FacturaForm('factura-form');

        return new ViewModel(array(
            'form' => $form
        ));
    }
}