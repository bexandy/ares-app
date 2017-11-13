<?php
/**
 * Created by PhpStorm.
 * User: brodriguez
 * Date: 05/04/17
 * Time: 01:36 PM
 */

namespace Kardex\Mapper;


use Kardex\Model\LoteEntity;
use Zend\Db\Adapter\Adapter;
use Zend\Db\ResultSet\HydratingResultSet;
use Zend\Db\Sql\Sql;
use Zend\Stdlib\Hydrator\ClassMethods;

class LoteMapper
{
    protected $tableName = 'lotes';
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
        $this->sql->setTable('lotes');
        $select = $this->sql->select();
        $statement = $this->sql->prepareStatementForSqlObject($select);
        $results = $statement->execute();

        $entityPrototype = new LoteEntity();
        $hydrator = new ClassMethods();
        $resultset = new HydratingResultSet($hydrator, $entityPrototype);
        $resultset->initialize($results);
        return $resultset;
    }

    public function saveLote(LoteEntity $lote)
    {
        $this->sql->setTable('lotes');
        $hydrator = new ClassMethods();
        $data = $hydrator->extract($lote);

        if ($lote->getId()) {
            // update action
            $action = $this->sql->update();
            $action->set($data);
            $action->where(array('id' => $lote->getId()));
        } else {
            // insert action
            $action = $this->sql->insert();
            unset($data['id']);
            $action->values($data);
        }
        $statement = $this->sql->prepareStatementForSqlObject($action);

        try {
            $result = $statement->execute();

        } catch (\Exception $e) {
            die($e->getMessage());
        }


        if (!$lote->getId()) {
            $lote->setId($result->getGeneratedValue());
        }

        return $result;
    }

    public function getLastCodigo($tipo)
    {
        $this->sql->setTable('lotes');
        $select = $this->sql->select();
        $select->columns(array('num_lote'));
        $select->where(array('tipo' => $tipo));
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
            return $result['num_lote'];

        }
    }

    public function getLote($id)
    {

        $select = $this->sql->select();
        $select->where(array('id' => $id));

        $statement = $this->sql->prepareStatementForSqlObject($select);
        $result = $statement->execute()->current();
        if (!$result) {
            return null;
        }

        $hydrator = new ClassMethods();
        $lote = new LoteEntity();
        $hydrator->hydrate($result, $lote);

        return $lote;
    }

    public function getLotesBy($where = array())
    {
        $this->sql->setTable('lotes');
        $select = $this->sql->select();
        if (count($where) > 0) {
            $select->where($where);
        }

        $statement = $this->sql->prepareStatementForSqlObject($select);
        $results = $statement->execute();

        $entityPrototype = new LoteEntity();
        $hydrator = new ClassMethods();
        $resultset = new HydratingResultSet($hydrator, $entityPrototype);
        $resultset->initialize($results);
        return $resultset;
    }

    public function generateCodigo($ultimoCodigo, $tipo)
    {
        $prefijo = "";
        if ((int) $tipo == 1) {
            $prefijo = 'LOT';
        }
        if ((int) $tipo == 2) {
            $prefijo = 'DET';
        }
        $ultimaSecuencia = substr($ultimoCodigo,-8);
        if (($ultimaSecuencia == 00000000) || ($ultimaSecuencia === 99999999)){
            $nuevoCodigo = (string) $prefijo.date('Ymd').'-00000001';
            return $nuevoCodigo;
        } else {
            //$ultimaSecuencia = substr($ultimoCodigo,-8);
            $nuevaSecuencia =  (int) $ultimaSecuencia + 1;
            $nuevoCodigo = $prefijo.date('Ymd').'-'.str_pad($nuevaSecuencia,8,'0',STR_PAD_LEFT);
            return $nuevoCodigo;
        }
    }

}