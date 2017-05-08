<?php
/**
 * Created by PhpStorm.
 * User: brodriguez
 * Date: 06/02/17
 * Time: 01:20 AM
 */

namespace Application\Controller;


use Zend\Mvc\Controller\AbstractActionController;

class UsuariosController extends AbstractActionController
{
    public function autenticadoAction()


    {
        $authorize = $this->serviceLocator->get('zfcUserAuthentication');

        if ($authorize->hasIdentity()) {
            // Disparamos un evento 'autentificacionEvent'
            $this->getEventManager()->trigger('autenticacionEvent', $this ,array());

        }
        return $this->redirect()->toRoute('home');
    }
}