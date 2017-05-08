<?php
/**
 * Created by PhpStorm.
 * User: brodriguez
 * Date: 05/02/17
 * Time: 10:06 PM
 */

namespace Mensajes\Service;


use Mensajes\Model\MensajesMapper;
use Zend\Session\Container;

class MensajesService
{
    protected $mensajesMapper;
    protected $session ;

    /**
     * MensajesService constructor.
     * @param $dbAdapter
     */
    public function __construct(MensajesMapper $mensajesMapper)
    {
        $this->mensajesMapper = $mensajesMapper;
        $this->session = new Container('mensajes');
    }

    public function buscarTodosMensajes()
    {
        return $this->mensajesMapper->fetchAll();
    }

    public function existeMensaje()
    {
        return $this->session->hayMensajes;
    }

    public function cargarMensajes()
    {
        $sesion = $this->session;
        if(!$sesion->id){
            $sesion->id=1;
        }

        $sesion->hayMensajes = $this->mensajesMapper->hayMensajes();
        $sesion->cantidad = $this->mensajesMapper->getCantidad();

        return $sesion;
    }

    public function getCantidad()
    {
        return $this->session->cantidad;
    }

    public function leerMensajes()
    {
        return $this->session;
    }
}