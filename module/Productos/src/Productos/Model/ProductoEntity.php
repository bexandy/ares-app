<?php
/**
 * Created by PhpStorm.
 * User: brodriguez
 * Date: 20/09/16
 * Time: 01:03 PM
 */

namespace Productos\Model;

class ProductoEntity
{
    protected $id;
    protected $idcategoria;
    protected $nombcategoria;
    protected $nombre;
    protected $unidadmedidaventas;
    protected $nombunidmedventas;
    protected $preciounidad;
    protected $unidadmedidaalmacen;
    protected $nombunidmedalmacen;
    protected $imagen;
    protected $idmarca;
    protected $relacionunidad;
    protected $nombmarca;
    protected $vencimiento;
    protected $codpremium;
    protected $modificado;
    protected $disponible;
    protected $ganancia;
    protected $tieneimpuesto;
    protected $impuesto;
    protected $precioventa;
    protected $montoganancia;
    protected $montoimpuesto;
    protected $preciocosto;
    protected $cantidad;

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
    public function getMontoganancia()
    {
        return $this->montoganancia;
    }

    /**
     * @param mixed $montoganancia
     */
    public function setMontoganancia($montoganancia)
    {
        $this->montoganancia = $montoganancia;
    }

    /**
     * @return mixed
     */
    public function getMontoimpuesto()
    {
        return $this->montoimpuesto;
    }

    /**
     * @param mixed $montoimpuesto
     */
    public function setMontoimpuesto($montoimpuesto)
    {
        $this->montoimpuesto = $montoimpuesto;
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
    public function getTieneimpuesto()
    {
        return $this->tieneimpuesto;
    }

    /**
     * @param mixed $tieneimpuesto
     */
    public function setTieneimpuesto($tieneimpuesto)
    {
        $this->tieneimpuesto = $tieneimpuesto;
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
    public function getPrecioventa()
    {
        return $this->precioventa;
    }

    /**
     * @param mixed $precioventa
     */
    public function setPrecioventa($precioventa)
    {
        $this->precioventa = $precioventa;
    }

    /**
     * @return mixed
     */
    public function getDisponible()
    {
        return $this->disponible;
    }

    /**
     * @param mixed $disponible
     */
    public function setDisponible($disponible)
    {
        $this->disponible = $disponible;
    }

    /**
     * @return mixed
     */
    public function getCodpremium()
    {
        return $this->codpremium;
    }

    /**
     * @param mixed $codpremium
     */
    public function setCodpremium($codpremium)
    {
        $this->codpremium = $codpremium;
    }

    /**
     * @return mixed
     */
    public function getModificado()
    {
        return $this->modificado;
    }

    /**
     * @param mixed $modificado
     */
    public function setModificado($modificado)
    {
        $this->modificado = $modificado;
    }

    /**
     * @return mixed
     */
    public function getVencimiento()
    {
        return $this->vencimiento;
    }

    /**
     * @param mixed $vencimiento
     */
    public function setVencimiento($vencimiento)
    {
        $this->vencimiento = $vencimiento;
    }

    /**
     * @return mixed
     */
    public function getNombmarca()
    {
        return $this->nombmarca;
    }

    /**
     * @param mixed $nombmarca
     */
    public function setNombmarca($nombmarca)
    {
        $this->nombmarca = $nombmarca;
    }


    /**
     * @return mixed
     */
    public function getIdmarca()
    {
        return $this->idmarca;
    }

    /**
     * @param mixed $idmarca
     */
    public function setIdmarca($idmarca)
    {
        $this->idmarca = $idmarca;
    }

    /**
     * @return mixed
     */
    public function getRelacionunidad()
    {
        return $this->relacionunidad;
    }

    /**
     * @param mixed $relacionunidad
     */
    public function setRelacionunidad($relacionunidad)
    {
        $this->relacionunidad = $relacionunidad;
    }

    /**
     * @return mixed
     */

    public function getId()
    {
        return $this->id;
    }

    public function setId($id)
    {
        $this->id = $id;
    }

    public function getIdcategoria()
    {
        return $this->idcategoria;
    }

    public function setIdcategoria($idcategoria)
    {
        $this->idcategoria = $idcategoria;
    }

    public function getNombcategoria()
    {
        return $this->nombcategoria;
    }

    public function setNombcategoria($nombcategoria)
    {
        $this->nombcategoria = $nombcategoria;
    }

    public function getNombre()
    {
        return $this->nombre;
    }

    public function setNombre($nombre)
    {
        $this->nombre = $nombre;
    }

    public function getUnidadmedidaventas()
    {
        return $this->unidadmedidaventas;
    }

    public function setUnidadmedidaventas($unidadmedidaventas)
    {
        $this->unidadmedidaventas = $unidadmedidaventas;
    }

    public function getNombunidmedventas()
    {
        return $this->nombunidmedventas;
    }

    public function setNombunidmedventas($nombunidmedventas)
    {
        $this->nombunidmedventas = $nombunidmedventas;
    }

    public function getPreciounidad()
    {
        return $this->preciounidad;
    }

    public function setPreciounidad($preciounidad)
    {
        $this->preciounidad = $preciounidad;
    }

    public function getUnidadmedidaalmacen()
    {
        return $this->unidadmedidaalmacen;
    }

    public function setUnidadmedidaalmacen($unidadmedidaalmacen)
    {
        $this->unidadmedidaalmacen = $unidadmedidaalmacen;
    }

    public function getNombunidmedalmacen()
    {
        return $this->nombunidmedalmacen;
    }

    public function setNombunidmedalmacen($nombunidmedalmacen)
    {
        $this->nombunidmedalmacen = $nombunidmedalmacen;
    }

    public function getImagen()
    {
        return $this->imagen;
    }

    public function setImagen($imagen)
    {
        $this->imagen = $imagen;
    }

    public function toArray()
    {
        return array(get_object_vars($this));
    }

}
