<?php
/**
 * Created by PhpStorm.
 * User: brodriguez
 * Date: 16/12/16
 * Time: 04:05 PM
 */

namespace Clientes\Controller;


use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class IndexController extends AbstractActionController
{
    public function indexAction()
    {
        $pedidoMapper = $this->getPedidoMapper();
        $pedidosCola = $pedidoMapper->fetchAllEstatus(array('2'));
        $pedidosDespacho = $pedidoMapper->fetchAllEstatus(array('3'));
        $usuarioMapper = $this->getUsuarioMapper();
        $users = $usuarioMapper->fetchAll();

        return new ViewModel(array(
                'pedidosCola' => $pedidosCola,
                'pedidosDespacho' => $pedidosDespacho,
                'users' => $users
            ));
    }

    public function getPedidoMapper()
    {
        $sm = $this->getServiceLocator();
        return $sm->get('PedidoMapper');
    }

    public function getUsuarioMapper()
    {
        $sm = $this->getServiceLocator();
        return $sm->get('UsuarioMapper');
    }
}