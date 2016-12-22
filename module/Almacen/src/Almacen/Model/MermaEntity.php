<?php
/**
 * Created by PhpStorm.
 * User: brodriguez
 * Date: 21/12/16
 * Time: 11:18 PM
 */

namespace Almacen\Model;


class MermaEntity
{
    protected $id;
    protected $idalmacen;
    protected $idproducto;
    protected $cantidad;
    protected $fecha;

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
    public function getIdalmacen()
    {
        return $this->idalmacen;
    }

    /**
     * @param mixed $idalmacen
     */
    public function setIdalmacen($idalmacen)
    {
        $this->idalmacen = $idalmacen;
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
    public function getCantidad()
    {
        return $this->cantidad;
    }

    /**
     * @param mixed $cantidad
     */
    public function setCantidad($cantidad)
    {
        $this->cantidad = $cantidad;
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

}