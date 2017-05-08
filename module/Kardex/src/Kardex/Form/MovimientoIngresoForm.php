<?php
/**
 * Created by PhpStorm.
 * User: brodriguez
 * Date: 03/05/17
 * Time: 06:50 PM
 */

namespace Kardex\Form;


use Almacen\Model\AlmacenMapper;
use Zend\Form\Form;

class MovimientoIngresoForm extends Form
{
    protected $almacenMapper;
    /**
     * MovimientoIngresoForm constructor.
     */
    public function __construct(AlmacenMapper $almacenMapper, $name = null, $options = array())
    {

        parent::__construct($name, $options);
        $this->almacenMapper = $almacenMapper;

        $movimientoFieldset = new \Kardex\Form\MovimientoFieldset($this->almacenMapper);
        $movimientoFieldset->setName('movimiento');
        $movimientoFieldset->useAsBaseFieldset(false);

        $this->add(array(
            'name'  =>  'ingreso',
            'type'  =>  'Kardex\Form\IngresoFieldset',
            'options' =>    array(
                'use_as_base_fieldset' => true,
            ),
        ));

        $this->add($movimientoFieldset);

        $this->add(array(
            'type' => 'Zend\Form\Element\Collection',
            'name' => 'detalles',
            'options' => array(
                'label' => 'Detalles del Movimiento',
                'should_create_template' => true,
                'template_placeholder' => '__placeholder__',
                'allow_add' => true,
                'target_element' => array(
                    'type' => 'Kardex\Form\DetallesMovimientoFieldset',
                ),
            ),
        ));

        $this->add(array(
            'name' => 'submit',
            'attributes' => array(
                'type'  => 'submit',
                'value' => 'Crear Ingreso',
                'class' => 'btn btn-primary',
            ),
        ));
    }

}