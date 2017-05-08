<?php
/**
 * Created by PhpStorm.
 * User: brodriguez
 * Date: 03/05/17
 * Time: 01:21 PM
 */

namespace Kardex\Form;

use Zend\Form\Form;

class MovimientoForm extends Form
{
     /**
     * MovimientoForm constructor.
     */
    public function __construct($name = null, $options = array())
    {


        parent::__construct($name,$options);

        $this->add(array(
            'name'  =>  'movimiento',
            'type'  =>  'Kardex\Form\MovimientoFieldset',
            'options' =>    array(
                'use_as_base_fieldset' => true,
            ),
        ));

        $this->add(array(
            'name' => 'submit',
            'attributes' => array(
                'type'  => 'submit',
                'value' => 'Procesar',
                'class' => 'btn btn-primary',
            ),
        ));
    }


}