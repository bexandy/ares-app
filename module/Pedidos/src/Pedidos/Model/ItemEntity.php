<?php
/**
 * Created by PhpStorm.
 * User: brodriguez
 * Date: 22/09/16
 * Time: 06:13 PM
 */

namespace Pedidos\Model;


class ItemEntity
{
    protected $pedido;
    protected $producto;
    protected $nombproducto;
    protected $unidmedprod;
    protected $cantidad;
    protected $subtotal;
    protected $ganancia;
    protected $impuesto;
    protected $preciocosto;

    /**
     * @return mixed
     */
    public function getGanancia()
    {
        return $this->ganancia;
    }

    /**
     * @param mixed $ganancia
     */
    public function setGanancia($ganancia)
    {
        $this->ganancia = $ganancia;
    }

        /**
     * @return mixed
     */
    public function getImpuesto()
    {
        return $this->impuesto;
    }

    /**
     * @param mixed $impuesto
     */
    public function setImpuesto($impuesto)
    {
        $this->impuesto = $impuesto;
    }

        /**
     * @return mixed
     */
    public function getPreciocosto()
    {
        return $this->preciocosto;
    }

    /**
     * @param mixed $preciocosto
     */
    public function setPreciocosto($preciocosto)
    {
        $this->preciocosto = $preciocosto;
    }

    /**
     * @return mixed
     */
    public function getPedido()
    {
        return $this->pedido;
    }

    /**
     * @param mixed $pedido
     */
    public function setPedido($pedido)
    {
        $this->pedido = $pedido;
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
    public function getNombproducto()
    {
        return $this->nombproducto;
    }

    /**
     * @param mixed $nombproducto
     */
    public function setNombproducto($nombproducto)
    {
        $this->nombproducto = $nombproducto;
    }

    /**
     * @return mixed
     */
    public function getUnidmedprod()
    {
        return $this->unidmedprod;
    }

    /**
     * @param mixed $unidmedprod
     */
    public function setUnidmedprod($unidmedprod)
    {
        $this->unidmedprod = $unidmedprod;
    }

    /**
     * @return mixed
     */
    public function getCantidad()
    {
        return (float) $this->cantidad;
    }

    /**
     * @param mixed $cantidad
     */
    public function setCantidad($cantidad)
    {
        $this->cantidad = (float) str_replace(",", ".", $cantidad);
    }

    /**
     * @return mixed
     */
    public function getSubtotal()
    {
        return (float) $this->subtotal;
    }

    /**
     * @param mixed $subtotal
     */
    public function setSubtotal($subtotal)
    {
        $this->subtotal = (float) $subtotal;
    }


}
