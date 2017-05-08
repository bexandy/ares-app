<?php
/**
 * Created by PhpStorm.
 * User: brodriguez
 * Date: 05/04/17
 * Time: 11:28 AM
 */

namespace Kardex\Model;


class LoteEntity
{
    protected $id;
    protected $num_lote;
    protected $ubicacion;
    protected $tipo;

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
    public function getNumLote()
    {
        return $this->num_lote;
    }

    /**
     * @param mixed $num_lote
     */
    public function setNumLote($num_lote)
    {
        $this->num_lote = $num_lote;
    }

    /**
     * @return mixed
     */
    public function getUbicacion()
    {
        return $this->ubicacion;
    }

    /**
     * @param mixed $ubicacion
     */
    public function setUbicacion($ubicacion)
    {
        $this->ubicacion = $ubicacion;
    }

    /**
     * @return int
     */
    public function getTipo()
    {
        return $this->tipo;
    }

    /**
     * @param int $tipo
     */
    public function setTipo($tipo)
    {
        $this->tipo = $tipo;
    }



}