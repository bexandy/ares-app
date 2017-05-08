<?php
/**
 * Created by PhpStorm.
 * User: brodriguez
 * Date: 12/02/17
 * Time: 01:28 PM
 */

namespace Kardex\Mapper;


use Almacen\Model\DisponibilidadAlmacenEntity;
use Productos\Model\MarcaEntity;
use Zend\Db\Adapter\Adapter;
use Zend\Db\ResultSet\HydratingResultSet;
use Zend\Db\ResultSet\ResultSet;
use Zend\Db\Sql\Sql;
use Zend\Paginator\Adapter\DbSelect;
use Zend\Paginator\Paginator;
use Zend\Stdlib\Hydrator\ClassMethods;

class InventarioMapper
{
    protected $tableName = 'vista-kardex-inventario';
    protected $dbAdapter;
    protected $sql;
    /**
     * AlmacenMapper constructor.
     */
    public function __construct(Adapter $dbAdapter)
    {
        $this->dbAdapter = $dbAdapter;
        $this->sql = new Sql($dbAdapter);
        $this->sql->setTable($this->tableName);
    }

    public function getInventario($where = array(), $paging = false)
    {
        $this->sql->setTable('vista-kardex-inventario');
        $select = $this->sql->select();
        if (count($where) > 0) {
            $select->where($where);
        }

        $hydrator = new ClassMethods();
        $disponibilidadAlmacen = new DisponibilidadAlmacenEntity();
        $resultset = new HydratingResultSet($hydrator, $disponibilidadAlmacen);

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
        $this->sql->setTable('vista-kardex-inventario');

        $select = $this->sql->select();
        $select->quantifier('DISTINCT');
        $select->columns(array(
            'id' => 'idmarca',
            'nombre' => 'marca',
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
        $this->sql->setTable('vista-kardex-inventario');

        $select = $this->sql->select();
        $select->quantifier('DISTINCT');
        $select->columns(array(
            'id' => 'idcategoria',
            'nombre' => 'categoria',
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

    public function getAlmacenDisponibles($where = array())
    {
        $this->sql->setTable('vista-kardex-inventario');

        $select = $this->sql->select();
        $select->quantifier('DISTINCT');
        $select->columns(array(
            'id' => 'idalmacen',
            'nombre' => 'nombre',
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