<?php
/**
 * Created by PhpStorm.
 * User: brodriguez
 * Date: 17/10/16
 * Time: 10:54 PM
 */
return array(
    'bjyauthorize' => array(
        'default_role' => 'guest',
        'login_redirect_route' => '/',
        //'identity_provider'  => 'BjyAuthorize\Provider\Identity\AuthenticationIdentityProvider',
        'identity_provider'     => 'BjyAuthorize\Provider\Identity\ZfcUserZendDb',
        'role_providers' => array(
            /*
            'BjyAuthorize\Provider\Role\ObjectRepositoryProvider' => array(
                'object_manager' => 'doctrine.entitymanager.orm_default',
                'role_entity_class' => 'Application\Entity\Role',
            ),
            */
            'BjyAuthorize\Provider\Role\Config' => array(
                'guest' => array(),
            ),
            'BjyAuthorize\Provider\Role\ZendDb' => array(
                'table'                 => 'user_role',
                'identifier_field_name' => 'id',
                'role_id_field'         => 'roleId',
                'parent_role_field'     => 'parent_id',
            ),
            /*
            'BjyAuthorize\Provider\Role\ObjectRepositoryProvider' => array(
                'role_entity_class' => 'Application\Entity\Role',
                'object_manager'    => 'doctrine.entitymanager.orm_default',
            ),
            */
        ),
        'resource_providers' => array(
            'BjyAuthorize\Provider\Resource\Config' => array(
                'Inicio' => array(),
                'Ventas' => array(),
                'Despacho' => array(),
                'Administracion' => array(),
            ),
        ),
        'rule_providers' => array(
            'BjyAuthorize\Provider\Rule\Config' => array(
                'allow' => array(
                    array('autenticado','Inicio','acceder'),
                    array('vendedor','Ventas',array('acceder','crear')),
                    array('administrador','Administracion',array('acceder','modificar')),
                    array('despachador','Despacho',array('acceder','crear','modificar')),
                    array('administrador','Despacho',array('acceder')),
                ),
            ),
        ),
        'guards' => array(
            'BjyAuthorize\Guard\Controller' => array(
                array('controller' => 'Application\Controller\Index', 'action' => 'index', 'roles' => array('autenticado', 'guest')),
                array('controller' => 'Clientes\Controller\Index', 'action' => 'index', 'roles' => array('autenticado', 'guest')),
                array(
                    'controller' => array('Pedidos\Controller\Pedido','Pedidos\Controller\Item'),
                    'roles' => array('vendedor','administrador')
                ),
                array(
                    'controller' => array('Application\Controller\Index'),
                    'action' => array('tienda'),
                    'roles' => array('vendedor','administrador')
                ),
                array(
                    'controller' => array('Application\Controller\Index'),
                    'action' => array('admin'),
                    'roles' => array('administrador')
                ),
                array(
                    'controller' => array('Despacho\Controller\Index'),
                    'roles' => array('administrador', 'despachador')
                ),
                array(
                    'controller' => array('Almacen\Controller\Almacen','Almacen\Controller\Inventario','Almacen\Controller\Movimiento','Almacen\Controller\Merma'),
                    'roles' => array('administrador')
                ),
                array(
                    'controller' => array('Productos\Controller\Producto','Productos\Controller\Categoria','Productos\Controller\UnidadMedida', 'Productos\Controller\Marca'),
                    'roles' => array('administrador')
                ),
                array(
                    'controller' => array('StickyNotes\Controller\StickyNotes'),
                    'roles' => array('guest', 'autenticado')
                ),
                array(
                    'controller' => array('TestAjax\Controller\Skeleton'),
                    'roles' => array('guest', 'autenticado')
                ),
                array(
                    'controller' => array('Reportes\Controller\Reportes'),
                    'roles' => array('administrador')
                ),
                array(
                    'controller' => array('Productos\Controller\MyForm'),
                    'roles' => array('administrador')
                ),
                array(
                    'controller' => array('Almacen\Controller\Ingreso'),
                    'roles' => array('administrador')
                ),
                array(
                    'controller' => array('Almacen\Controller\Traslado'),
                    'roles' => array('administrador')
                ),
                array(
                    'controller' => array('Usuarios\Controller\Usuarios'),
                    'roles' => array('administrador')
                ),
                array(
                    'controller' => array('Almacen\Controller\Merma'),
                    'roles' => array('administrador', 'despachador')
                ),
                array('controller' => 'zfcuser', 'roles' => array()),
                array('controller' => 'HtProfileImage\ProfileImage', 'roles' => array()),
                array('controller' => 'zfcuseradmin', 'roles' => array()),
                array('controller' => 'ZfcAdmin\Controller\AdminController', 'roles' => array()),
                // Below is the default index action used by the ZendSkeletonApplication
                // array('controller' => 'Application\Controller\Index', 'roles' => array('guest', 'user')),
            ),

        ),
    ),
);
