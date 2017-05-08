<?php
/**
 * Created by PhpStorm.
 * User: brodriguez
 * Date: 01/05/17
 * Time: 07:45 PM
 */

namespace Kardex\Mapper;


use Kardex\Model\MovimientoEntity;
use Zend\Db\Adapter\Adapter;
use Zend\Db\Sql\Sql;
use Zend\Stdlib\Hydrator\ClassMethods;

class MovimientoMapper
{
    protected $tableName = 'movimientos';
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

    public function insertMovimiento(MovimientoEntity $movimiento)
    {
        $this->sql->setTable('movimientos');
        $hydrator = new ClassMethods();
        $data = $hydrator->extract($movimiento);

        $action = $this->sql->insert();
        unset($data['id']);
        $action->values($data);

        $statement = $this->sql->prepareStatementForSqlObject($action);

        try {
            $result = $statement->execute();

        } catch (\Exception $e) {
            die($e->getMessage());
        }

        return $result;
    }
}