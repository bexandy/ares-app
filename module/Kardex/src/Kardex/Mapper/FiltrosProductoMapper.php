<?php
/**
 * Created by PhpStorm.
 * User: brodriguez
 * Date: 17/04/17
 * Time: 01:16 PM
 */

namespace Kardex\Mapper;


use Productos\Model\ProductoEntity;
use Zend\Db\Adapter\Adapter;
use Zend\Db\ResultSet\HydratingResultSet;
use Zend\Db\ResultSet\ResultSet;
use Zend\Db\Sql\Sql;
use Zend\Paginator\Adapter\DbSelect;
use Zend\Paginator\Paginator;
use Zend\Stdlib\Hydrator\ClassMethods;

class FiltrosProductoMapper
{
    protected $tableName = 'vista_productos';
    protected $dbAdapter;
    protected $sql;

    public function __construct(Adapter $dbAdapter)
    {
        $this->dbAdapter = $dbAdapter;
        $this->sql = new Sql($dbAdapter);
        $this->sql->setTable($this->tableName);
    }

    public function getProductos($where = array(), $paging = false)
    {
        $this->sql->setTable('vista_productos');
        $select = $this->sql->select();
        if (count($where) > 0) {
            $select->where($where);
        }

        $hydrator = new ClassMethods();
        $productos = new ProductoEntity();
        $resultset = new HydratingResultSet($hydrator, $productos);

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

    public function getMarcasDisponibles($where = array())
    {
        $this->sql->setTable('vista_productos');

        $select = $this->sql->select();
        $select->quantifier('DISTINCT');
        $select->columns(array(
            'id' => 'idmarca',
            'nombre' => 'nombmarca',
        ));

        if (count($where) > 0) {
            $select->where($where);
        }

        $statement = $this->sql->prepareStatementForSqlObject($select);
        $results = $statement->execute();
        $resultset = new ResultSet();
        $resultset->initialize($results);
        return $resultset;
    }

    public function getCategoriasDisponibles($where = array())
    {
        $this->sql->setTable('vista_productos');

        $select = $this->sql->select();
        $select->quantifier('DISTINCT');
        $select->columns(array(
            'id' => 'idcategoria',
            'nombre' => 'nombcategoria',
        ));

        if (count($where) > 0) {
            $select->where($where);
        }

        $statement = $this->sql->prepareStatementForSqlObject($select);
        $results = $statement->execute();
        $resultset = new ResultSet();
        $resultset->initialize($results);
        return $resultset;
    }
}