<?php
/**
 * Created by PhpStorm.
 * User: brodriguez
 * Date: 26/04/17
 * Time: 08:55 AM
 */

namespace Kardex\Model;


class DocumentoEntity
{
    protected $id;
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
    public function getTipo()
    {
        return $this->tipo;
    }

    /**
     * @param mixed $tipo
     */
    public function setTipo($tipo)
    {
        $this->tipo = $tipo;
    }


}