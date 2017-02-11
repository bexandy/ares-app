<?php
/**
 * Created by PhpStorm.
 * User: brodriguez
 * Date: 11/02/17
 * Time: 01:13 AM
 */

namespace Sample\Model;


use Zend\Db\Adapter\Adapter;
use Zend\Db\Adapter\AdapterAwareInterface;
use Zend\Db\ResultSet\ResultSet;
use Zend\Db\Sql\Sql;
use Zend\Db\TableGateway\AbstractTableGateway;
use Zend\Paginator\Adapter\DbSelect;
use Zend\Paginator\Paginator;

class StateTable extends AbstractTableGateway implements AdapterAwareInterface
{

    protected $table = 'states';

    public function setDbAdapter(Adapter $adapter) {
        $this->adapter = $adapter;
        $this->resultSetPrototype = new ResultSet(ResultSet::TYPE_ARRAY);
        $this->initialize();
    }

    public function getStates($where = array(), $columns = array(), $paging = false, $orderBy = '') {

        $sql = new Sql($this->getAdapter());
        $select = $sql->select()
            ->from(array('state' => $this->table));

        $select->join(array('country' => 'countries'), 'country.country_id = state.country_id', array('country_name'), $select::JOIN_INNER);

        if (count($where) > 0) {
            $select->where($where);
        }

        if (count($columns) > 0) {
            $select->columns($columns);
        }

        if ($orderBy != '') {
            $select->order($orderBy);
        } else {
            $select->order('state.state_id desc');
        }

        if ($paging) {
            $adapter = new DbSelect($select, $sql);
            $paginator = new Paginator($adapter);
            return $paginator;
        } else {
            $statement = $sql->prepareStatementForSqlObject($select);
            $states = $this->resultSetPrototype->initialize($statement->execute())->toArray();
            return $states;
        }
    }
}