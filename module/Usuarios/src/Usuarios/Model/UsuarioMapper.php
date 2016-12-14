<?php
/**
 * Created by PhpStorm.
 * User: brodriguez
 * Date: 09/12/16
 * Time: 05:59 PM
 */

namespace Usuarios\Model;


use Application\Entity\User;
use Zend\Crypt\Password\Bcrypt;
use Zend\Db\Adapter\Adapter;
use Zend\Db\ResultSet\HydratingResultSet;
use Zend\Db\Sql\Sql;
use Zend\Form\Form;
use Zend\Paginator\Adapter\DbSelect;
use Zend\Paginator\Paginator;
use Zend\Stdlib\Hydrator\ClassMethods;
use ZfcUser\Options\ModuleOptions;

class UsuarioMapper
{
    protected $tableName = 'users';
    protected $dbAdapter;
    protected $sql;
    protected $zfcUserOptions;

    public function __construct(Adapter $dbAdapter)
    {
        $this->dbAdapter = $dbAdapter;
        $this->sql = new Sql($dbAdapter);
        $this->sql->setTable($this->tableName);
    }

    public function fetchAll($paginated=false)
    {
        $this->sql->setTable('user');

        $entityPrototype = new User();
        $hydrator = new ClassMethods();
        $resultset = new HydratingResultSet($hydrator, $entityPrototype);

        $select = $this->sql->select();
        $select->columns(array(
            'id' => 'user_id',
            'username' => 'username',
            'displayName' => 'display_name',
            'password' => 'password',
        ));


        if ($paginated) {

            $paginatorAdapter = new DbSelect($select,$this->dbAdapter, $resultset);
            $paginator = new Paginator($paginatorAdapter);
            return $paginator;
        }

        $statement = $this->sql->prepareStatementForSqlObject($select);
        $results = $statement->execute();
        $resultset->initialize($results);
        return $resultset;
    }

    public function edit(Form $form, array $data, User $user)
    {
        // first, process all form fields
        foreach ($data as $key => $value) {
            if ($key == 'password') continue;

            $setter = $this->getAccessorName($key);
            if (method_exists($user, $setter)) call_user_func(array($user, $setter), $value);
        }

        $argv = array();

        if (!empty($data['password'])) {
            $argv['password'] = $data['password'];
        }

        if (!empty($argv['password'])) {
            $bcrypt = new Bcrypt();
            $bcrypt->setCost(6);
            $user->setPassword($bcrypt->create($argv['password']));
        }



        $this->saveUser($user);

        return $user;
    }

    protected function getAccessorName($property, $set = true)
    {
        $parts = explode('_', $property);
        array_walk($parts, function (&$val) {
            $val = ucfirst($val);
        });
        return (($set ? 'set' : 'get') . implode('', $parts));
    }


    public function saveUser(User $user)
    {
        $this->sql->setTable('user');
        $hydrator = new ClassMethods();
        $data = $hydrator->extract($user);

        if ($user->getId()) {
            // update action
            $action = $this->sql->update();
            unset($data['id']);
            unset($data['email']);
            unset($data['password']);
            unset($data['state']);
            unset($data['roles']);
            $action->set($data);
            $action->where(array('user_id' => $user->getId()));
        } else {
            // insert action
            $action = $this->sql->insert();
            unset($data['id']);
            unset($data['email']);
            unset($data['state']);
            unset($data['roles']);
            $action->values($data);
        }
        $statement = $this->sql->prepareStatementForSqlObject($action);
        $result = $statement->execute();

        if (!$user->getId()) {
            $user->setId($result->getGeneratedValue());
        }
        return $result;
    }



    public function findById($id)
    {

        $this->sql->setTable('user');

        $select = $this->sql->select();
        $select->columns(array(
            'id' => 'user_id',
            'username' => 'username',
            'displayName' => 'display_name',
            'password' => 'password',
        ));
        $select->where(array('user_id' => $id));

        $statement = $this->sql->prepareStatementForSqlObject($select);
        $result = $statement->execute()->current();
        if (!$result) {
            return null;
        }

        $entityPrototype = new User();
        $hydrator = new ClassMethods();
        $hydrator->hydrate($result, $entityPrototype);

        return $entityPrototype;
    }


}