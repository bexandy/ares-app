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
            'kardex' => array(
                'type' => 'Literal',
                'options' => array(
                    'route' => '/kardex',
                    'defaults' => array(
                        '__NAMESPACE__' => 'Kardex\Controller',
                        'controller' => 'Index',
                        'action' => 'index'
                    )
                ),
                'may_terminate' => true,
                'child_routes' => array(
                    'inventario' => array(
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
            'Kardex\Controller\Inventario' => Kardex\Controller\InventarioController::class,
            'Kardex\Controller\Lote' => Kardex\Controller\LoteController::class,
            'Kardex\Controller\Ingreso' => Kardex\Controller\IngresoController::class
        ),
        'factories' => array(
            'Kardex\Controller\Index' => Kardex\Factory\IndexControllerFactory::class,
        ),
    ),
    'view_manager' => array(
        'template_map' => array(
            'kardex/index/index' => __DIR__ . '/../view/kardex/index/index.phtml',
        ),
        'template_path_stack' => array(
            __DIR__ . '/../view',
        ),
    ),
    'form_elements' => array(
        'factories' => array(
            'Kardex\Form\AlbumFieldset' => 'Kardex\Form\AlbumFieldsetFactory',
        ),
    ),
    'service_manager' => array(
        'invokables' => array(
            'Kardex\Model\CountryTable' => 'Kardex\Model\CountryTable',
            'Kardex\Model\StateTable' => 'Kardex\Model\StateTable',
            'Kardex\Service\Inventario' => 'Kardex\Service\InventarioService',
            'Kardex\Service\FiltrosProducto' => 'Kardex\Service\FiltrosProductoService'
        ),
    ),
);
