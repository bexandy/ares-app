<?php
/**
 * Created by PhpStorm.
 * User: brodriguez
 * Date: 11/02/17
 * Time: 01:10 AM
 */

namespace Sample\Model;


use Zend\Db\Adapter\Adapter;
use Zend\Db\Adapter\AdapterAwareInterface;
use Zend\Db\ResultSet\ResultSet;
use Zend\Db\Sql\Sql;
use Zend\Db\TableGateway\AbstractTableGateway;
use Zend\Paginator\Adapter\DbSelect;
use Zend\Paginator\Paginator;

class CountryTable extends AbstractTableGateway implements AdapterAwareInterface
{

    protected $table = 'countries';

    public function setDbAdapter(Adapter $adapter) {
        $this->adapter = $adapter;
        $this->resultSetPrototype = new ResultSet(ResultSet::TYPE_ARRAY);
        $this->initialize();
    }

    public function getCountries($where = array(), $columns = array(), $paging = false, $orderBy = ''){

        $sql = new Sql($this->getAdapter());
        $select = $sql->select()
            ->from(array('country' => $this->table));
        if(count($where) > 0){
            $select->where($where);
        }

        if(count($columns) > 0){
            $select->columns($columns);
        }

        if($orderBy != ''){
            $select->order($orderBy);
        }else{
            $select->order('country.country_id desc');
        }

        if($paging){
            $adapter = new DbSelect($select, $sql);
            $paginator = new Paginator($adapter);
            return $paginator;
        }else{
            $statement = $sql->prepareStatementForSqlObject($select);
            $countries = $this->resultSetPrototype->initialize($statement->execute())->toArray();
            return $countries;
        }
    }
}