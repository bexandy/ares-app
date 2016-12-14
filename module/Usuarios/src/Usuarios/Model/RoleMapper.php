<?php
/**
 * Created by PhpStorm.
 * User: brodriguez
 * Date: 12/12/16
 * Time: 03:50 PM
 */

namespace Usuarios\Model;


use Application\Entity\Role;
use Application\Entity\User;
use BjyAuthorize\Acl\HierarchicalRoleInterface;
use RoleUserBridge\Mapper\RoleInterface;
use Zend\Db\Adapter\Adapter;
use Zend\Db\ResultSet\HydratingResultSet;
use Zend\Db\Sql\Sql;
use Zend\Paginator\Adapter\DbSelect;
use Zend\Paginator\Paginator;
use Zend\Stdlib\Hydrator\ClassMethods;

class RoleMapper
{
    protected $tableName = 'user_role';
    protected $dbAdapter;
    protected $sql;
    protected $roleMapper;

    public function __construct(Adapter $dbAdapter)
    {
        $this->dbAdapter = $dbAdapter;
        $this->sql = new Sql($dbAdapter);
        $this->sql->setTable($this->tableName);
    }

    public function fetchAll()
    {
        $this->sql->setTable('user_role');

        $entityPrototype = new Role();
        $hydrator = new ClassMethods();
        $resultset = new HydratingResultSet($hydrator, $entityPrototype);

        $select = $this->sql->select();


        $statement = $this->sql->prepareStatementForSqlObject($select);
        $results = $statement->execute();
        $resultset->initialize($results);
        return $resultset;
    }

    public function update($userId, $roleId)
    {
        $this->sql->setTable('user_role_linker');

        $action = $this->sql->update();
        $action->set(array('role_id' => $roleId));
        $action->where(array('user_id' => $userId));

        $statement = $this->sql->prepareStatementForSqlObject($action);
        $result = $statement->execute();

        return $result;
    }

    public function getRolesById($id)
    {

        $this->sql->setTable('user_role_linker');

        //$id = $user->getId();

        $select = $this->sql->select();

        $select->columns(array(
            'user_id' => 'user_id',
            'roleId' => 'role_id',
        ));

        $select->join('user_role', 'user_role_linker.role_id = user_role.roleId', array('id' => 'id'), 'left');

        $select->where(array('user_id' => $id));

        $statement = $this->sql->prepareStatementForSqlObject($select);
        $result = $statement->execute()->current();
        if (!$result) {
            return null;
        }

        $hydrator = new ClassMethods();
        $role = new Role();
        $hydrator->hydrate($result, $role);

        return $role;
    }

    public function getRoles()
    {
        $result = $this->fetchAll();
        $roles  = array();

        foreach ($result as $role) {
            $id = $role->getId();
            $roleId = $role->getRoleId();
            $parent = null;

            if ($role instanceof HierarchicalRoleInterface && $parent = $role->getParent()) {
                $parent = $parent->getRoleId();
            }

            $roles[$id] = $role;
        }

        // Pass Two: Re-inject parent objects to preserve hierarchy
        /* @var $roleObj \BjyAuthorize\Acl\Role */
        foreach ($roles as $roleObj) {
            $parentRoleObj = $roleObj->getParent();

            if ($parentRoleObj && $parentRoleObj->getRoleId()) {
                $roleObj->setParent($roles[$parentRoleObj->getRoleId()]);
            }
        }

        return array_values($roles);
    }

    public function getRoleId($Rolid)
    {

        $this->sql->setTable('user_role');

        $select = $this->sql->select();

        $select->columns(array(
            'roleId' => 'roleId',
        ));

        $select->where(array('id' => $Rolid));

        $statement = $this->sql->prepareStatementForSqlObject($select);
        $result = $statement->execute()->current();
        if (!$result) {
            return null;
        }
        return array_pop($result);
    }

    public function save($userId, $roleId)
    {
        $this->sql->setTable('user_role_linker');

        $action = $this->sql->insert();
        $action->values(array('user_id' => $userId,'role_id' => $roleId ));

        $statement = $this->sql->prepareStatementForSqlObject($action);
        $result = $statement->execute();

        return $result;
    }

}