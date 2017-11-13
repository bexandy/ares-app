<?php
/**
 * Created by PhpStorm.
 * User: brodriguez
 * Date: 15/06/17
 * Time: 10:17 PM
 */

namespace Kardex\Form;


use Almacen\Model\AlmacenMapper;
use Kardex\Model\MovimientoIngresoEntity;
use Zend\Form\Fieldset;
use Zend\Stdlib\Hydrator\ClassMethods;

class MovimientoIngresoFieldset extends Fieldset
{
    protected $almacenMapper;
    /**
     * MovimientoIngresoFieldset constructor.
     */
    public function __construct(AlmacenMapper $almacenMapper, $name = null, $options = array())
    {
        parent::__construct($name = null, $options = array());

        $this->setHydrator(new ClassMethods(false))
            ->setObject(new MovimientoIngresoEntity());

        $this->almacenMapper = $almacenMapper;

        $movimientoFieldset = new \Kardex\Form\MovimientoFieldset($this->almacenMapper);
        $movimientoFieldset->setName('movimiento');

        $opcionesFieldset = new \Kardex\Form\OpcionesDetallesMovimientoFieldset();
        $opcionesFieldset->setName('opciones');

        $this->add(array(
            'name'  =>  'ingreso',
            'type'  =>  'Kardex\Form\IngresoFieldset',
        ));

        $this->add($movimientoFieldset);

        $this->add($opcionesFieldset);

        $this->add(array(
            'type' => 'Zend\Form\Element\Collection',
            'name' => 'detalles',
            'options' => array(
                'should_create_template' => true,
                'template_placeholder' => '__placeholder__',
                'allow_add' => true,
                'allow_remove' => true,
                'target_element' => array(
                    'type' => 'Kardex\Form\DetallesMovimientoFieldset',
                ),
            ),
        ));

    }
}