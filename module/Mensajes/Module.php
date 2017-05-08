<?php
/**
 * Created by PhpStorm.
 * User: brodriguez
 * Date: 05/02/17
 * Time: 10:04 PM
 */

namespace Mensajes;


use Mensajes\Listener\CargarMensajesListener;
use Mensajes\Model\MensajesMapper;
use Mensajes\Service\MensajesService;
use Zend\Mvc\ModuleRouteListener;
use Zend\Mvc\MvcEvent;

class Module
{
    //Este método se ejecuta cada vez que carga una página
    public function onBootstrap(MvcEvent $e)
    {
        $eventManager        = $e->getApplication()->getEventManager();
        $moduleRouteListener = new ModuleRouteListener();
        $moduleRouteListener->attach($eventManager);

        $mensajesService = $e->getApplication()->getServiceManager()->get('MensajesService');
        $eventManager->attachAggregate(new CargarMensajesListener($mensajesService));


    }

    public function getConfig()
    {
        return include __DIR__ . '/config/module.config.php';
    }

    public function getAutoloaderConfig()
    {
        return array(
            'Zend\Loader\StandardAutoloader' => array(
                'namespaces' => array(
                    __NAMESPACE__ => __DIR__ . '/src/' . __NAMESPACE__,
                ),
            ),
        );
    }

    public function getServiceConfig()
    {
        return array(
            'factories' => array(
                'MensajesService' => function ($sm) {
                    $dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
                    $mensajesMapper = new MensajesMapper($dbAdapter);
                    $mensajesService = new MensajesService($mensajesMapper);
                    return $mensajesService;
                },
                'MensajesMapper' => function ($sm) {
                    $dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
                    $mensajesMapper = new MensajesMapper($dbAdapter);
                    return $mensajesMapper;
                },
            ),
        );
    }
}
