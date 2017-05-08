<?php
/**
 * Created by PhpStorm.
 * User: brodriguez
 * Date: 26/04/17
 * Time: 09:09 AM
 */

namespace Kardex\Mapper;


use Zend\Db\Adapter\Adapter;
use Zend\Db\Sql\Sql;

class DocumentoMapper
{
    protected $tableName = 'documentos';
    protected $dbAdapter;
    protected $sql;
    /**
     * LoteMapper constructor.
     */
    public function __construct(Adapter $dbAdapter)
    {
        $this->dbAdapter = $dbAdapter;
        $this->sql = new Sql($dbAdapter);
        $this->sql->setTable($this->tableName);
    }

    public function crearNuevo($tipo)
    {
       $action = $this->sql->insert();
       $action->values(array(
           'tipo' => $tipo
       ));

       $statement = $this->sql->prepareStatementForSqlObject($action);

        try {
            $result = $statement->execute();

        } catch (\Exception $e) {
            die($e->getMessage());
        }


        return $result->getGeneratedValue();
    }
}
