<?php
/**
 * Created by PhpStorm.
 * User: brodriguez
 * Date: 26/04/17
 * Time: 11:59 AM
 */

namespace Kardex\Form;


use Zend\Form\Form;
use Zend\Stdlib\Hydrator\ClassMethods;

class IngresoForm extends Form
{

    /**
     * IngresoForm constructor.
     */
    public function __construct($name = null, $options = array())
    {
        parent::__construct($name, $options);

        $this->add(array(
            'name'  =>  'ingreso',
            'type'  =>  'Kardex\Form\IngresoFieldset',
            'options' =>    array(
                'use_as_base_fieldset' => true,
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