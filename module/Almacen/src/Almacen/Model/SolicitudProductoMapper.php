<?php
/**
 * Created by PhpStorm.
 * User: brodriguez
 * Date: 25/01/17
 * Time: 01:10 PM
 */

namespace Almacen\Model;


use Zend\Db\Adapter\Adapter;
use Zend\Db\ResultSet\HydratingResultSet;
use Zend\Db\Sql\Sql;
use Zend\Stdlib\Hydrator\ClassMethods;

class SolicitudProductoMapper
{
    protected $tableName = 'solicitud_producto';
    protected $dbAdapter;
    protected $sql;

    public function __construct(Adapter $dbAdapter)
    {
        $this->dbAdapter = $dbAdapter;
        $this->sql = new Sql($dbAdapter);
        $this->sql->setTable($this->tableName);
    }

    public function fetchAll()
    {
        $select = $this->sql->select();
        $statement = $this->sql->prepareStatementForSqlObject($select);
        $results = $statement->execute();

        $entityPrototype = new SolicitudProductoEntity();
        $hydrator = new ClassMethods();
        $resultset = new HydratingResultSet($hydrator, $entityPrototype);
        $resultset->initialize($results);
        return $resultset->toArray();
    }

    public function getSolicitudesActivas()
    {
        //$select = $this->sql->select();
        $select->columns(array(
            'id' => 'id',
            'idproducto' => 'idproducto',
            'fecha' => 'fecha',
            'estatus' => 'estatus'
        ));
        $select->join('productos', 'productos.id = solicitud_producto.idproducto', array('nombre' => 'nombre'), 'left');
        $select->where(array('estatus' => 1));

        $statement = $this->sql->prepareStatementForSqlObject($select);
        $results = $statement->execute();

        $entityPrototype = new SolicitudProductoEntity();
        $hydrator = new ClassMethods();
        $resultset = new HydratingResultSet($hydrator, $entityPrototype);
        $resultset->initialize($results);
        return $resultset;
    }

    public function saveSolicitud(SolicitudProductoEntity $solicitud)
    {
        $hydrator = new ClassMethods();
        $data = $hydrator->extract($solicitud);

        if ($solicitud->getId()) {
            // update action
            unset($data['nombre']);
            $action = $this->sql->update();
            $action->set($data);
            $action->where(array('id' => $solicitud->getId()));
        } else {
            // insert action
            $action = $this->sql->insert();
            unset($data['id']);
            unset($data['nombre']);
            $action->values($data);
        }
        $statement = $this->sql->prepareStatementForSqlObject($action);
        $result = $statement->execute();

        if (!$solicitud->getId()) {
            $solicitud->setId($result->getGeneratedValue());
        }
        return $result;
    }

    public function existeSolicitud($idproducto)
    {
        $select = $this->sql->select();
        $select->columns(array('id' => 'id'));
        $select->where(array('idproducto' => $idproducto));

        $statement = $this->sql->prepareStatementForSqlObject($select);
        $result = $statement->execute()->current();

        if (!$result) {
            return null;
        }

        return $result;
    }

    public function getSolicitud($idproducto)
    {
        $select = $this->sql->select();
        $select->where(array('idproducto' => $idproducto));

        $statement = $this->sql->prepareStatementForSqlObject($select);
        $result = $statement->execute()->current();

        if (!$result) {
            return null;
        }
        $entityPrototype = new SolicitudProductoEntity();
        $hydrator = new ClassMethods();
        $hydrator->hydrate($result, $entityPrototype);

        return $entityPrototype;
    }

}