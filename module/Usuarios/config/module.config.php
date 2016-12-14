<?php
/**
 * Created by PhpStorm.
 * User: brodriguez
 * Date: 04/12/16
 * Time: 09:55 PM
 */
return array(
    'view_manager' => array(
        'template_path_stack' => array(
            __DIR__.'/../view',
        ),
    ),
    'controllers' => array(
        'invokables' => array(
            'Usuarios\Controller\Usuarios' => 'Usuarios\Controller\UsuariosController',
        ),
    ),
    'router' => array(
        'routes' => array(
            'usuarios' => array(
                'type'    => 'Literal',
                'options' => array(
                    'route'    => '/usuarios',
                    'defaults' => array(
                        '__NAMESPACE__' => 'Usuarios\Controller',
                        'controller'    => 'Usuarios',
                        'action'        => 'index',
                    ),
                ),
                'may_terminate' => true,
                'child_routes' =>array(
                    'list' => array(
                        'type' => 'Segment',
                        'options' => array(
                            'route' => '/list[/:p]',
                            'defaults' => array(
                                'controller' => 'Usuarios',
                                'action'     => 'list',
                            ),
                        ),
                    ),
                    'create' => array(
                        'type' => 'Literal',
                        'options' => array(
                            'route' => '/create',
                            'defaults' => array(
                                'controller' => 'Usuarios',
                                'action'     => 'create'
                            ),
                        ),
                    ),
                    'edit' => array(
                        'type' => 'Segment',
                        'options' => array(
                            'route' => '/edit/:userId',
                            'defaults' => array(
                                'controller' => 'Usuarios\Controller\Usuarios',
                                'action'     => 'edit',
                                'userId'     => 0
                            ),
                        ),
                    ),
                    'remove' => array(
                        'type' => 'Segment',
                        'options' => array(
                            'route' => '/remove/:userId',
                            'defaults' => array(
                                'controller' => 'Usuarios',
                                'action'     => 'remove',
                                'userId'     => 0
                            ),
                        ),
                    ),
                ),
            ),
        ),

    ),
);