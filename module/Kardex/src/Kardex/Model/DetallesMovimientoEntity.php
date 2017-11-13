<?php
/**
 * Created by PhpStorm.
 * User: brodriguez
 * Date: 05/04/17
 * Time: 11:24 AM
 */

namespace Kardex\Model;


class DetallesMovimientoEntity
{
    protected $id;
    protected $movimiento;
    protected $producto;
    protected $lote;
    protected $cantidad;
    protected $unidadmedida;
    protected $um;
    protected $costo;
    protected $vencimiento;

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
    public function getMovimiento()
    {
        return $this->movimiento;
    }

    /**
     * @param mixed $movimiento
     */
    public function setMovimiento($movimiento)
    {
        $this->movimiento = $movimiento;
    }

    /**
     * @return mixed
     */
    public function getProducto()
    {
        return $this->producto;
    }

    /**
     * @param mixed $producto
     */
    public function setProducto($producto)
    {
        $this->producto = $producto;
    }

    /**
     * @return mixed
     */
    public function getLote()
    {
        return $this->lote;
    }

    /**
     * @param mixed $lote
     */
    public function setLote($lote)
    {
        $this->lote = $lote;
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
    public function getUnidadmedida()
    {
        return $this->unidadmedida;
    }

    /**
     * @param mixed $unidadmedida
     */
    public function setUnidadmedida($unidadmedida)
    {
        $this->unidadmedida = $unidadmedida;
    }

}