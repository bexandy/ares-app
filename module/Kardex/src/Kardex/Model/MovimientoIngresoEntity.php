<?php
/**
 * Created by PhpStorm.
 * User: brodriguez
 * Date: 13/06/17
 * Time: 12:04 AM
 */

namespace Kardex\Model;


use Kardex\Form\OpcionesDetallesMovimientoFieldset;

class MovimientoIngresoEntity
{
    protected $movimiento;
    protected $opciones;
    protected $ingreso;
    protected $detalles;

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
    public function setMovimiento(MovimientoEntity $movimiento)
    {
        $this->movimiento = $movimiento;
    }

    /**
     * @return mixed
     */
    public function getOpciones()
    {
        return $this->opciones;
    }

    /**
     * @param mixed $opciones
     */
    public function setOpciones(OpcionesDetallesMovimientoEntity $opciones)
    {
        $this->opciones = $opciones;
    }

    /**
     * @return mixed
     */
    public function getIngreso()
    {
        return $this->ingreso;
    }

    /**
     * @param mixed $ingreso
     */
    public function setIngreso(IngresoEntity $ingreso)
    {
        $this->ingreso = $ingreso;
    }

    /**
     * @return mixed
     */
    public function getDetalles()
    {
        return $this->detalles;
    }

    /**
     * @param mixed $detalles
     */
    public function setDetalles(array $detalles)
    {
        $this->detalles = $detalles;
    }


}