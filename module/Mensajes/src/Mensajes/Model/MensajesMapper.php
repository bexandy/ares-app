<?php
/**
 * Created by PhpStorm.
 * User: brodriguez
 * Date: 05/02/17
 * Time: 10:08 PM
 */

namespace Mensajes\Model;


use Zend\Db\Adapter\Adapter;
use Zend\Db\ResultSet\HydratingResultSet;
use Zend\Db\Sql\Sql;
use Zend\Stdlib\Hydrator\ClassMethods;

class MensajesMapper
{
    protected $tableName = 'solicitud_producto';
    protected $dbAdapter;
    protected $sql;

    /**
     * MensajesService constructor.
     * @param $dbAdapter
     */
    public function __construct(Adapter $dbAdapter)
    {
        $this->dbAdapter = $dbAdapter;
        $this->sql = new Sql($dbAdapter);
        $this->sql->setTable($this->tableName);
    }

    public function fetchAll()
    {
        $select = $this->sql->select();
        $select->where(array('estatus' => 1));
        $statement = $this->sql->prepareStatementForSqlObject($select);
        $results = $statement->execute();

        $entityPrototype = new MensajesEntity();
        $hydrator = new ClassMethods();
        $resultset = new HydratingResultSet($hydrator, $entityPrototype);
        $resultset->initialize($results);
        return $resultset->toArray();
    }

    public function hayMensajes()
    {
        $select = $this->sql->select();
        $select->columns(array('id' => 'id'));
        $select->where(array('estatus' => 1));
        $select->limit(1);

        $statement = $this->sql->prepareStatementForSqlObject($select);
        $result = $statement->execute()->current();

        if($result){
            return true;
        }else{
            return false;
        }
    }

    public function getCantidad()
    {
        $select = $this->sql->select();
        $select->columns(array('id' => 'id'));
        $select->where(array('estatus' => 1));

        $statement = $this->sql->prepareStatementForSqlObject($select);
        $result = $statement->execute()->count();

        if($result){
            return $result;
        }else{
            return false;
        }
    }

    public function guardarMensaje(MensajesEntity $mensaje)
    {
        $hydrator = new ClassMethods();
        $data = $hydrator->extract($mensaje);

        if ($mensaje->getId()) {
            // update action
            $action = $this->sql->update();
            $action->set($data);
            $action->where(array('id' => $mensaje->getId()));
        } else {
            // insert action
            $action = $this->sql->insert();
            unset($data['id']);
            $action->values($data);
        }
        $statement = $this->sql->prepareStatementForSqlObject($action);
        $result = $statement->execute();

        if (!$mensaje->getId()) {
            $mensaje->setId($result->getGeneratedValue());
        }
        return $result;
    }
}