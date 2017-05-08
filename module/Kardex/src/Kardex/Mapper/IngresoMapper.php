<?php
/**
 * Created by PhpStorm.
 * User: brodriguez
 * Date: 26/04/17
 * Time: 10:28 AM
 */

namespace Kardex\Mapper;


use Kardex\Model\IngresoEntity;
use Zend\Db\Adapter\Adapter;
use Zend\Db\ResultSet\HydratingResultSet;
use Zend\Db\Sql\Sql;
use Zend\Stdlib\Hydrator\ClassMethods;

class IngresoMapper
{
    protected $tableName = 'ingreso';
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

    public function fetchAll()
    {
        $this->sql->setTable('ingreso');
        $select = $this->sql->select();
        $statement = $this->sql->prepareStatementForSqlObject($select);
        $results = $statement->execute();

        $entityPrototype = new IngresoEntity();
        $hydrator = new ClassMethods();
        $resultset = new HydratingResultSet($hydrator, $entityPrototype);
        $resultset->initialize($results);
        return $resultset;
    }

    public function getLastCodigo()
    {
        $this->sql->setTable('ingreso');
        $select = $this->sql->select();
        $select->columns(array('codigo'));
        $select->order('id DESC');
        $select->limit(1);

        //echo $select->getSqlString($this->dbAdapter->getPlatform());
        //die();
        $statement = $this->sql->prepareStatementForSqlObject($select);

        try {
            $result = $statement->execute()->current();

        } catch (\Exception $e) {
            die($e->getMessage());
        }

        $result = $statement->execute()->current();

        if (!$result) {
            return 0;
        } else {
            return $result['codigo'];

        }
    }

    public function insertIngreso(IngresoEntity $ingreso)
    {
        $this->sql->setTable('ingreso');
        $hydrator = new ClassMethods();
        $data = $hydrator->extract($ingreso);

        $action = $this->sql->insert();
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