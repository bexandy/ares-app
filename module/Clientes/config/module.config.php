<?php
/**
 * Created by PhpStorm.
 * User: brodriguez
 * Date: 16/12/16
 * Time: 04:03 PM
 */
return array(
    'view_manager' => array(
        'template_path_stack' => array(
            __DIR__.'/../view',
        ),
    ),
    'controllers' => array(
        'invokables' => array(
            'Clientes\Controller\Index' => 'Clientes\Controller\IndexController',
        ),
    ),
    'router' => array(
        'routes' => array(
            'clientes' => array(
                'type'    => 'Segment',
                'options' => array(
                    'route'    => '/clientes',
                    'defaults' => array(
                        '__NAMESPACE__' => 'Clientes\Controller',
                        'controller'    => 'Index',
                        'action'        => 'index',
                    ),
                ),
            ),
        ),
    ),
);