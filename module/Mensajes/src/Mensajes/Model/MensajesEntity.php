<?php
/**
 * Created by PhpStorm.
 * User: brodriguez
 * Date: 05/02/17
 * Time: 10:09 PM
 */

namespace Mensajes\Model;


class MensajesEntity
{
    protected $id;
    protected $idproducto;
    protected $estatus;

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return mixed
     */
    public function getIdproducto()
    {
        return $this->idproducto;
    }

    /**
     * @param mixed $idproducto
     */
    public function setIdproducto($idproducto)
    {
        $this->idproducto = $idproducto;
    }

    /**
     * @return mixed
     */
    public function getEstatus()
    {
        return $this->estatus;
    }

    /**
     * @param mixed $estatus
     */
    public function setEstatus($estatus)
    {
        $this->estatus = $estatus;
    }

    /**
     * @return mixed
     */
    public function getFecha()
    {
        return $this->fecha;
    }

    /**
     * @param mixed $fecha
     */
    public function setFecha($fecha)
    {
        $this->fecha = $fecha;
    }
    protected $fecha;

}