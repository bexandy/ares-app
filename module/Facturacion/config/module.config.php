<?php
/**
 * Created by PhpStorm.
 * User: brodriguez
 * Date: 22/02/17
 * Time: 01:07 PM
 */
return array(
    'router' => array(
        'routes' => array(
            'facturacion' => array(
                'type' => 'Literal',
                'options' => array(
                    'route' => '/facturas',
                    'defaults' => array(
                        '__NAMESPACE__' => 'Facturacion\Controller',
                        'controller' => 'Factura',
                        'action' => 'index'
                    )
                ),
                'may_terminate' => true,
                'child_routes' => array(
                    'default' => array(
                        'type' => 'Segment',
                        'options' => array(
                            'route' => '/[:controller[/:action]]',
                            'constraints' => array(
                                'controller' => '[a-zA-Z][a-zA-Z0-9_-]*',
                                'action' => '[a-zA-Z][a-zA-Z0-9_-]*'
                            ),
                        ),
                        'may_terminate' => true,
                        'child_routes' => array(
                            'wildcard' => array(
                                'type' => 'Wildcard'
                            ),
                        ),
                    ),
                ),
            ),
        ),
    ),
    'controllers' => array(
        'invokables' => array(
            'Facturacion\Controller\Proveedor' => Facturacion\Controller\ProveedorController::class,
            'Facturacion\Controller\Factura' => Facturacion\Controller\FacturaController::class
        ),

    ),
    'service_manager' => array(
    ),
    'view_manager' => array(
        'template_path_stack' => array(
            __DIR__.'/../view',
        ),
    ),
);