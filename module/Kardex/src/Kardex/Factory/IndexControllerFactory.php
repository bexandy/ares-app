<?php
/**
 * Created by PhpStorm.
 * User: brodriguez
 * Date: 16/02/17
 * Time: 11:24 PM
 */

namespace Kardex\Factory;


use Kardex\Controller\IndexController;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class IndexControllerFactory implements FactoryInterface
{
    function __invoke()
    {
        // TODO: Implement __invoke() method.
    }

    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $formManager = $serviceLocator->getServiceLocator()->get('FormElementManager');
        $form = $formManager->get('Kardex\Form\CreateAlbum');
        return new IndexController($form);
    }


}