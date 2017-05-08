<?php
/**
 * Created by PhpStorm.
 * User: brodriguez
 * Date: 22/02/17
 * Time: 10:46 PM
 */

namespace Facturacion\Form;


use Zend\Form\Form;

class ProveedorForm extends Form
{
    function __construct($name = null, $options = array())
    {
        parent::__construct($name, $options);

        $this->add(array(
            'name' => 'nombre',
            'type' => 'text',
            'required' => true,
            'options' => array(
                'label' => 'Nombre',
            ),
            'attributes' => array(
                'id' => 'nombre',
                'maxlength' => 100,
                'class' => 'form-control',
            )
        ));

        $this->add(array(
            'name' => 'submit',
            'attributes' => array(
                'type'  => 'submit',
                'value' => 'Crear',
                'class' => 'btn btn-primary',
            ),
        ));
    }


}