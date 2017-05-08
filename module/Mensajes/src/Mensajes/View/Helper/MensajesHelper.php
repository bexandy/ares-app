<?php
/**
 * Created by PhpStorm.
 * User: brodriguez
 * Date: 05/02/17
 * Time: 10:17 PM
 */

namespace Mensajes\View\Helper;


use Zend\EventManager\EventInterface;
use Zend\ServiceManager\ServiceLocatorAwareInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Zend\View\Helper\AbstractHelper;


class MensajesHelper extends AbstractHelper implements ServiceLocatorAwareInterface
{
    protected $serviceLocator;

    public function __invoke()
    {
        $authorize = $this->serviceLocator->get('BjyAuthorizeServiceAuthorize');

        if ($authorize->isAllowed('Administracion','acceder')){
            $mensajesService = $this->serviceLocator->get('MensajesService');
            $session = $mensajesService->leerMensajes();
            if (isset($session) && $session->hayMensajes) {
                $url = $this->getServiceLocator()->get('viewhelpermanager')->get('url');
                $routeurl = $url('agotado', array('action' => 'listado-solicitudes'));
                echo ("<div class=\"alert alert-warning alert-dismissible\" role=\"alert\">
                    <button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-label=\"Close\">
                        <span aria-hidden=\"true\">&times;</span></button>
                    ¡Atención! Hay <strong>".$session->cantidad."</strong> solicitudes de productos pendientes.
                    <a href=\"".$routeurl."\">Ver Solicitudes</a>
                    </div>");
            }
        }
    }


    public function setServiceLocator(ServiceLocatorInterface $serviceLocator)
    {
        $this->serviceLocator = $serviceLocator->getServiceLocator();
    }


    public function getServiceLocator()
    {
        return $this->serviceLocator;
    }
}