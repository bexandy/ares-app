<?php
/**
 * Created by PhpStorm.
 * User: brodriguez
 * Date: 03/05/17
 * Time: 12:17 PM
 */

namespace Kardex\Form;


use Zend\Form\Form;
use Zend\Stdlib\Hydrator\ClassMethods;

class DetallesMovimientoForm extends Form
{

    /**
     * DetallesMovimientoForm constructor.
     */
    public function __construct($name = null, $options = array())
    {
        parent::__construct($name, $options);

        $this->add(array(
            'name'  =>  'detalles',
            'type'  =>  'Kardex\Form\DetallesMovimientoFieldset',
            'options' =>    array(
                'use_as_base_fieldset' => true,
            ),
        ));


        $this->add(array(
            'name' => 'submit',
            'attributes' => array(
                'type'  => 'submit',
                'value' => 'Añadir',
                'class' => 'btn btn-primary',
            ),
        ));
    }
}