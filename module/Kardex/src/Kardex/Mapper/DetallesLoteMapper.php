<?php
/**
 * Created by PhpStorm.
 * User: brodriguez
 * Date: 05/04/17
 * Time: 04:16 PM
 */

namespace Kardex\Mapper;


use Kardex\Model\DetallesLoteEntity;
use Zend\Db\Adapter\Adapter;
use Zend\Db\ResultSet\HydratingResultSet;
use Zend\Db\Sql\Sql;
use Zend\Paginator\Adapter\DbSelect;
use Zend\Paginator\Paginator;
use Zend\Stdlib\Hydrator\ClassMethods;

class DetallesLoteMapper
{
    protected $tableName = 'detalles_lote';
    protected $dbAdapter;
    protected $sql;

    /**
     * DetallesLoteMapper constructor.
     * @param $dbAdapter
     */
    public function __construct(Adapter $dbAdapter)
    {
        $this->dbAdapter = $dbAdapter;
        $this->sql = new Sql($dbAdapter);
        $this->sql->setTable($this->tableName);
    }

    public function saveDetallesLote(DetallesLoteEntity $detallesLoteEntity)
    {
        $this->sql->setTable('detalles_lote');
        $hydrator = new ClassMethods();
        $data = $hydrator->extract($detallesLoteEntity);

        if ($detallesLoteEntity->getId()) {
            // update action
            $action = $this->sql->update();
            unset($data['nombproducto']);
            unset($data['numlote']);
            $action->set($data);
            $action->where(array('id' => $detallesLoteEntity->getId()));
        } else {
            // insert action
            $action = $this->sql->insert();
            unset($data['id']);
            unset($data['nombproducto']);
            unset($data['numlote']);
            $action->values($data);
        }
        //echo $action->getSqlString($this->dbAdapter->getPlatform());
        //die();

        $statement = $this->sql->prepareStatementForSqlObject($action);

        try {
            $result = $statement->execute();

        } catch (\Exception $e) {
            die($e->getMessage());
        }


        if (!$detallesLoteEntity->getId()) {
            $detallesLoteEntity->setId($result->getGeneratedValue());
        }

        return $result;
    }
    public function getDetallesLote($where = array(), $paging = false)
    {
        $this->sql->setTable('vista_detalles_lote');
        $select = $this->sql->select();
        if (count($where) > 0) {
            $select->where($where);
        }

        $hydrator = new ClassMethods();
        $detallesLote = new DetallesLoteEntity();
        $resultset = new HydratingResultSet($hydrator, $detallesLote);

        if ($paging) {
            $adapter = new DbSelect($select, $this->sql);
            $paginator = new Paginator($adapter);
            return $paginator;
        } else {
            $statement = $this->sql->prepareStatementForSqlObject($select);
            $result = $statement->execute();
            if (!$result) {
                return null;
            }
            $resultset->initialize($result);

            return $resultset->toArray();
        }
    }

    public function getDetallesLoteById($where = array())
    {
        $this->sql->setTable('vista_detalles_lote');

        $select = $this->sql->select();
        if (count($where) > 0) {
            $select->where($where);
        }

        $hydrator = new ClassMethods();
        $detallesLote = new DetallesLoteEntity();

        $statement = $this->sql->prepareStatementForSqlObject($select);
        $result = $statement->execute()->current();

        if (!$result) {
            return null;
        }

        $hydrator->hydrate($result,$detallesLote);

        return $detallesLote;


    }

    public function getIdMatchLote($producto, $costo, $vencimiento)
    {
        $this->sql->setTable('detalles_lote');
        $select = $this->sql->select();
        $select->columns(array('id'));
        $select->where(array('producto' => $producto, 'costo' => $costo, 'vencimiento' => $vencimiento));

        $statement = $this->sql->prepareStatementForSqlObject($select);
        try {
            $result = $statement->execute()->current();

        } catch (\Exception $e) {
            die($e->getMessage());
        }
        if (!$result) {
            return null;
        } else {
            return $result['id'];

        }
    }
}