<?php
/**
 * Created by PhpStorm.
 * User: brodriguez
 * Date: 05/02/17
 * Time: 10:06 PM
 */

namespace Mensajes\Listener;


use Mensajes\Service\MensajesService;
use Zend\EventManager\EventInterface;
use Zend\EventManager\EventManagerInterface;
use Zend\EventManager\ListenerAggregateInterface;

class CargarMensajesListener implements ListenerAggregateInterface
{
    protected $listeners = array();
    protected $mensajesService;

    public function __construct(MensajesService $mensajesService)
    {
        $this->mensajesService = $mensajesService;
    }

    public function attach(EventManagerInterface $events)
    {

        $sharedEvents = $events->getSharedManager();
        $this->listeners[] = $sharedEvents->attach('Almacen\Controller\MermaController', 'nuevaSolicitudEvent', array($this, 'cargarDatosSession'),100);
        $this->listeners[] = $sharedEvents->attach('Almacen\Controller\TrasladoController', 'procesarSolicitudEvent', array($this, 'cargarDatosSession'),100);
        $this->listeners[] = $sharedEvents->attach('ZfcUser\Authentication\Adapter\AdapterChain', 'authenticate.success', array($this, 'cargarDatosSession'),100);
        // $events->attach(MvcEvent::EVENT_DISPATCH,array($this, 'cargarDatosSession'),100);
    }

    public function detach(EventManagerInterface $events)
    {
        foreach ($this->listeners as $index=>$listener) {
            if ($events->detach($listener)) {
                unset($this->listeners[$index]);
            }
        }
    }

    public function cargarDatosSession(EventInterface $event)
    {
        $this->mensajesService->cargarMensajes();
    }
}