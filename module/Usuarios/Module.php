<?php
/**
 * Created by PhpStorm.
 * User: brodriguez
 * Date: 04/12/16
 * Time: 09:52 PM
 */

namespace Usuarios;


use Usuarios\Form\EditarUsuarioForm;
use Usuarios\Model\RoleMapper;
use Usuarios\Model\UsuarioMapper;
use Zend\ModuleManager\Feature\AutoloaderProviderInterface;
use Zend\ModuleManager\Feature\ConfigProviderInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use ZfcUser\Form\RegisterFilter;
use ZfcUserAdmin\Validator\NoRecordExistsEdit;

class Module implements AutoloaderProviderInterface, ConfigProviderInterface
{
    public function getAutoloaderConfig()
    {
        return array(
            'Zend\Loader\StandardAutoloader' => array(
                'namespaces' => array(
                    // Autoload all classes from namespace 'Blog' from '/module/Blog/src/Blog'
                    __NAMESPACE__ => __DIR__ . '/src/' . __NAMESPACE__,
                )
            )
        );
    }

    public function getConfig()
    {
        return include __DIR__.'/config/module.config.php';
    }

    public function getServiceConfig()
    {
        return array(
            'factories' => array(
                'UsuarioMapper' => function ($sm) {
                    $dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
                    $mapper = new UsuarioMapper($dbAdapter);
                    return $mapper;
                },
                'RoleMapper' => function ($sm) {
                    $dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
                    $mapper = new RoleMapper($dbAdapter);
                    return $mapper;
                },
                'EditarUsuarioForm' => function ($sm) {
                    $roleMapper = $sm->get('RoleMapper');
                    $mapper = new EditarUsuarioForm($roleMapper);
                    return $mapper;
                },
            ),
        );
    }
}