<?php
/**
 * Created by PhpStorm.
 * User: brodriguez
 * Date: 21/12/16
 * Time: 11:20 PM
 */

namespace Almacen\Model;


use Zend\Db\Adapter\Adapter;
use Zend\Db\Sql\Sql;
use Zend\Stdlib\Hydrator\ClassMethods;

class MermaMapper
{
    protected $tableName = 'merma_x_almacen';
    protected $dbAdapter;
    protected $sql;

    public function __construct(Adapter $dbAdapter)
    {
        $this->dbAdapter = $dbAdapter;
        $this->sql = new Sql($dbAdapter);
        $this->sql->setTable($this->tableName);
    }

    public function saveMerma(MermaEntity $merma)
    {
        $this->sql->setTable('merma_x_almacen');
        $hydrator = new ClassMethods();
        $data = $hydrator->extract($merma);

        // insert action
        $action = $this->sql->insert();
        $action->values($data);

        $statement = $this->sql->prepareStatementForSqlObject($action);
        $result = $statement->execute();

        if (!$merma->getId()) {
            $merma->setId($result->getGeneratedValue());
        }
        return $result;
    }
}