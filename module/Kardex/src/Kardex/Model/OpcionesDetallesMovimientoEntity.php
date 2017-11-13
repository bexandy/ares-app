<?php
/**
 * Created by PhpStorm.
 * User: brodriguez
 * Date: 15/06/17
 * Time: 09:58 PM
 */

namespace Kardex\Model;


class OpcionesDetallesMovimientoEntity
{
    protected $loteDefault;
    protected $idLoteDefault;
    protected $opcLote;

    /**
     * @return mixed
     */
    public function getLoteDefault()
    {
        return $this->loteDefault;
    }

    /**
     * @param mixed $loteDefault
     */
    public function setLoteDefault($loteDefault)
    {
        $this->loteDefault = $loteDefault;
    }

    /**
     * @return mixed
     */
    public function getIdLoteDefault()
    {
        return $this->idLoteDefault;
    }

    /**
     * @param mixed $idLoteDefault
     */
    public function setIdLoteDefault($idLoteDefault)
    {
        $this->idLoteDefault = $idLoteDefault;
    }

    /**
     * @return mixed
     */
    public function getOpcLote()
    {
        return $this->opcLote;
    }

    /**
     * @param mixed $opcLote
     */
    public function setOpcLote($opcLote)
    {
        $this->opcLote = $opcLote;
    }




}