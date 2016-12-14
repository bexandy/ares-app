<?php
/**
 * Created by PhpStorm.
 * User: brodriguez
 * Date: 13/12/16
 * Time: 04:29 PM
 */

namespace Usuarios\Form;


use Zend\InputFilter\InputFilter;

class CrearUsuarioFilter extends InputFilter
{
    public function __construct()
    {
        $this->add(array(
            'name' => 'username',
            'required' => true,
        ));

        $this->add(array(
            'name' => 'display_name',
            'required' => true,
            'filters' => array(
                array('name' => 'StripTags'),
                array('name' => 'StringTrim'),
            ),
            'validators' => array(
                array(
                    'name' => 'StringLength',
                    'options' => array(
                        'encoding' => 'UTF-8',
                        'max' => 100
                    ),
                ),
            ),
        ));

        $this->add(array(
            'name' => 'password',
            'required' => true,
            'filters' => array(
                array('name' => 'StripTags'),
                array('name' => 'StringTrim'),
            ),
            'validators' => array(
                array(
                    'name' => 'StringLength',
                    'options' => array(
                        'encoding' => 'UTF-8',
                        'min' => 6,
                        'max' => 100
                    ),
                ),
            ),
        ));

    }
}