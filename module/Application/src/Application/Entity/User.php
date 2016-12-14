<?php
/**
 * BjyAuthorize Module (https://github.com/bjyoungblood/BjyAuthorize)
 *
 * @link https://github.com/bjyoungblood/BjyAuthorize for the canonical source repository
 * @license http://framework.zend.com/license/new-bsd New BSD License
 */
 
namespace Application\Entity;

use BjyAuthorize\Provider\Role\ProviderInterface;
use Doctrine\ORM\Mapping as ORM;
use Zend\Db\ResultSet\HydratingResultSet;
use Zend\Stdlib\Hydrator\ClassMethods;
use ZfcUser\Entity\UserInterface;

class User implements UserInterface, ProviderInterface
{

    protected $id;

    protected $username;

    protected $email;

    protected $displayName;

    protected $password;

    protected $state;

    protected $roles;

    public function __construct()
    {

        $this->roles = array();
    }

    public function getId()
    {
        return $this->id;
    }

   public function setId($id)
    {
        $this->id = (int) $id;
    }

    public function getUsername()
    {
        return $this->username;
    }

    public function setUsername($username)
    {
        $this->username = $username;
    }

    public function getEmail()
    {
        return $this->email;
    }

    public function setEmail($email)
    {
        $this->email = $email;
    }

    public function getDisplayName()
    {
        return $this->displayName;
    }


    public function setDisplayName($displayName)
    {
        $this->displayName = $displayName;
    }


    public function getPassword()
    {
        return $this->password;
    }

    public function setPassword($password)
    {
        $this->password = $password;
    }

    public function getState()
    {
        return $this->state;
    }

    public function setState($state)
    {
        $this->state = $state;
    }

    public function getRoles()
    {

      return $this->roles;
    }

    public function addRole($role)
    {
        $this->roles[] = $role;
    }
}
