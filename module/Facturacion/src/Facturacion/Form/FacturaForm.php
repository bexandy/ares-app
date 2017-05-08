<?php
/**
 * Created by PhpStorm.
 * User: brodriguez
 * Date: 23/02/17
 * Time: 11:50 AM
 */

namespace Facturacion\Form;


use Zend\Form\Form;

class FacturaForm extends Form
{
    public function __construct($name = null, $options = array())
    {
        parent::__construct($name, $options);

        $this->setAttribute('method','post');

        $this->add(array(
            'name' => 'datos',
            'type' => 'Facturacion\Form\DatosFacturaFieldset',
            'options' => array(
                'use_as_base_fieldset' => true,
            ),
        ));

        $this->add(array(
            'name' => 'detalles',
            'type' => 'Zend\Form\Element\Collection',
            'options' => array(
                'label' => 'Detalles de la Factura',
                'count' => 1,
                'should_create_template' => true,
                'template_placeholder' => '__placeholder__',
                //'allow_add' => true,
                'target_element' => array(
                    'type' => 'Facturacion\Form\DetallesFacturaFieldset',
                ),
            ),
        ));

        $this->add(array(
            'name' => 'submit',
            'attributes' => array(
                'type'  => 'submit',
                'value' => 'Ingresar Factura',
                'class' => 'btn btn-primary',
            ),
        ));
    }
}