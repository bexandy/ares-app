<?php
/**
 * Created by PhpStorm.
 * User: brodriguez
 * Date: 11/02/17
 * Time: 01:07 AM
 */
return array(
    'router' => array(
        'routes' => array(
            'sample' => array(
                'type' => 'Literal',
                'options' => array(
                    'route' => '/sample',
                    'defaults' => array(
                        '__NAMESPACE__' => 'Sample\Controller',
                        'controller' => 'Index',
                        'action' => 'index'
                    )
                ),
                'may_terminate' => true,
                'child_routes' => array(
                    'sample' => array(
                        'type' => 'Segment',
                        'options' => array(
                            'route' => '/[:controller[/:action]]',
                            'constraints' => array(
                                'controller' => '[a-zA-Z][a-zA-Z0-9_-]*',
                                'action' => '[a-zA-Z][a-zA-Z0-9_-]*'
                            )
                        ),
                        'may_terminate' => true,
                        'child_routes' => array(
                            'wildcard' => array(
                                'type' => 'Wildcard'
                            )
                        )
                    )
                )
            )
        ),
    ),
    'controllers' => array(
        'invokables' => array(
            'Sample\Controller\Index' => 'Sample\Controller\IndexController'
        ),
    ),
    'view_manager' => array(
        'template_map' => array(
            'sample/index/index' => __DIR__ . '/../view/sample/index/index.phtml',
        ),
        'template_path_stack' => array(
            __DIR__ . '/../view',
        ),
    ),
);
