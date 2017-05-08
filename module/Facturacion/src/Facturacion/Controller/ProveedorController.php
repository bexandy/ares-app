<?php
/**
 * Created by PhpStorm.
 * User: brodriguez
 * Date: 22/02/17
 * Time: 01:11 PM
 */

namespace Facturacion\Controller;


use Facturacion\Form\ProveedorForm;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class ProveedorController extends AbstractActionController
{
    public function indexAction()
    {
        return new ViewModel();
    }

    public function showformAction()
    {
        $viewmodel  = new ViewModel();
        $form       = $this->getForm();
        $request    = $this->getRequest();

        //disable layout if request by Ajax
        $viewmodel->setTerminal($request->isXmlHttpRequest());

        $is_xmlhttprequest = 1;
        if (! $request->isXmlHttpRequest()) {
            //if NOT using Ajax
            $is_xmlhttprequest = 0;
            if ($request->isPost()){
                $form->setData($request->getPost());
                if ($form->isValid()){
                    $this->savetodb($form->getData());
                }
            }
        }

        $viewmodel->setVariables(array(
            'form' => $form,
            // is_xmlhttprequest is needed for check this form is in modal dialog or not
            // in view
            'is_xmlhttprequest' => $is_xmlhttprequest
        ));

        return $viewmodel;
    }

    public function validatepostajaxAction()
    {
        $form       = $this->getForm();
        $request    = $this->getRequest();
        $response   = $this->getResponse();

        $messages   = array();

        if ($request->isPost()){
            $form->setData($request->getPost());

            if (! $form->isValid()){
                $errors = $form->getMessages();
                foreach($errors as $key => $row)
                {
                    if (!empty($row) && $key != 'submit'){
                        foreach($row as $keyer => $rower)
                        {
                            // save error(s) per-element that
                            // needed by Javascript
                            $messages[$key][] = $rower;
                        }
                    }
                }
            }

            if (!empty($messages)){
                $response->setContent(\Zend\Json\Json::encode($messages));
            } else {
                //save to db<img src="https://s0.wp.com/wp-content/mu-plugins/wpcom-smileys/twemoji/2/svg/1f609.svg" alt="😉" class="emoji" draggable="false">
                $this->savetodb($form->getData());
                $response->setContent(\Zend\Json\Json::encode(array('success' => 1)));
            }

        }

        return $response;
    }

    protected function getForm()
    {
        $form       = new ProveedorForm('proveedor-form');

        return $form;
    }

    public function savetodb()
    {
        // codigo
    }
}