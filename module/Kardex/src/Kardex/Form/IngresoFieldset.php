<?php
/**
 * Created by PhpStorm.
 * User: brodriguez
 * Date: 03/05/17
 * Time: 07:04 PM
 */

namespace Kardex\Form;


use Zend\Form\Fieldset;
use Zend\Stdlib\Hydrator\ClassMethods;

class IngresoFieldset extends Fieldset
{

    /**
     * IngresoFieldset constructor.
     */
    public function __construct($name = null, $options = array())
    {
        parent::__construct($name, $options);
        $this->setAttribute('method', 'post');
        $this->setHydrator(new ClassMethods());

        $this->add(array(
            'type'  =>  'hidden',
            'name'  =>  'id',
        ));

        $this->add(array(
            'type'  =>  'hidden',
            'name'  =>  'tipodoc',
        ));

        $this->add(array(
            'type'  =>  'text',
            'name'  =>  'codigo',
            'options'   =>  array(
                'label' =>  'Código de Ingreso',
            ),
            'attributes' => array(
                'readonly' => true,
                'disabled' => true,
                //'class' => 'form-control',
            ),
        ));

        $this->add(array(
            'type'  =>  'textarea',
            'name'  =>  'descripcion',
            'options'   =>  array(
                'label' =>  'Descripción',
            ),
            'attributes' => array(
                'class' => 'form-control',
                'cols' => 60,
                'rows' => 3
            )
        ));
    }
}