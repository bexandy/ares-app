<?php
/**
 * Created by PhpStorm.
 * User: brodriguez
 * Date: 05/12/16
 * Time: 06:19 PM
 */

namespace Usuarios\Form;



use BjyAuthorize\Provider\Role\ObjectRepositoryProvider;
use BjyAuthorize\Provider\Role\ProviderInterface;
use Usuarios\Model\RoleMapper;
use Zend\Form\Form;
use Zend\Stdlib\Hydrator\ClassMethods;
use ZfcUser\Entity\UserInterface;
use ZfcUser\Form\Register;
use ZfcUser\Options\RegistrationOptionsInterface;
use ZfcUserAdmin\Options\UserEditOptionsInterface;

class EditarUsuarioForm extends Form
{
    protected $provider;
    protected $userEditOptions;
    protected $userEntity;
    protected $serviceManager;
    protected $roleMapper;

    public function __construct(RoleMapper $roleMapper)
    {
        $this->roleMapper = $roleMapper;
        parent::__construct($name = null, $options = array());


        $this->setAttribute('method', 'post');
        $this->setHydrator(new ClassMethods());

        $this->add(array(
            'name' => 'userId',
            'type' => 'hidden',
        ));

        $this->add(array(
            'name' => 'id',
            'type' => 'hidden',
        ));

        $this->add(array(
            'name' => 'rolId',
            'type' => 'hidden',
            'attributes' => array(
                'id' => 'rolId',
            )
        ));

        $this->add(array(
            'name' => 'username',
            'type' => 'text',
            'options' => array(
                'label' => 'Usuario',
            ),
            'attributes' => array(
                'id' => 'usuario',
                'maxlength' => 15,
                'class' => 'form-control',
            )
        ));

        $this->add(array(
            'name' => 'display_name',
            'type' => 'text',
            'options' => array(
                'label' => 'Nombre de Usuario',
            ),
            'attributes' => array(
                'id' => 'display_name',
                'class' => 'form-control',
            )
        ));

        $this->add(array(
            'type' => 'Zend\Form\Element\Select',
            'name' => 'select_roles',
            'options' => array(
                'label' => 'Rol: ',
                'required' => true,
                'empty_option' => 'Seleccione un Rol',
                'value_options' => $this->getRolesForSelect(),
            ),
            'attributes' => array(
                'id' => 'select_roles',
                'class' => 'form-control',
            )
        ));

        $this->add(array(
            'name' => 'password',
            'type' => 'password',
            'options' => array(
                'label' => 'Contraseña (Sólo si quiere cambiarla)',
            ),
            'attributes' => array(
                'id' => 'password',
                'class' => 'form-control',
            )
        ));

        $this->add(array(
            'name' => 'submit',
            'attributes' => array(
                'type'  => 'submit',
                'value' => 'Guardar',
                'class' => 'btn btn-success btn-lg',
            ),
        ));

    }


    public function getRolesForSelect()
    {

        $roles = $this->roleMapper->getRoles();


        $selectData = array();

        foreach ($roles as $id=>$rol) {
            $selectData[$id+1] = $rol->getRoleId();
        }
        return $selectData;
    }

    public function setUser($userEntity)
    {
        $this->userEntity = $userEntity;
        $this->getEventManager()->trigger('userSet', $this, array('user' => $userEntity));
    }

    public function setUserEditOptions(UserEditOptionsInterface $userEditOptions)
    {
        $this->userEditOptions = $userEditOptions;
        return $this;
    }

    public function getUserEditOptions()
    {
        return $this->userEditOptions;
    }

    public function setServiceManager($serviceManager)
    {
        $this->serviceManager = $serviceManager;
    }

    public function getServiceManager()
    {
        return $this->serviceManager;
    }

    public function populateFromUser(UserInterface $user)
    {
        foreach ($this->getElements() as $element) {
            /** @var $element \Zend\Form\Element */
            $elementName = $element->getName();
            if (strpos($elementName, 'password') === 0) continue;

            $getter = $this->getAccessorName($elementName, false);
            if (method_exists($user, $getter)) $element->setValue(call_user_func(array($user, $getter)));
        }
/*
        foreach ($this->getUserEditOptions()->getEditFormElements() as $element) {
            $getter = $this->getAccessorName($element, false);
            $this->get($element)->setValue(call_user_func(array($user, $getter)));
        }
*/
        $this->get('userId')->setValue($user->getId());
    }

    protected function getAccessorName($property, $set = true)
    {
        $parts = explode('_', $property);
        array_walk($parts, function (&$val) {
            $val = ucfirst($val);
        });
        return (($set ? 'set' : 'get') . implode('', $parts));
    }

}