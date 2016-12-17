<?php
/**
 * Created by PhpStorm.
 * User: brodriguez
 * Date: 15/12/16
 * Time: 06:00 PM
 */

namespace Productos\Form;


use Zend\InputFilter\InputFilter;

class MarcaFilter extends InputFilter
{
    public function __construct()
    {
        $this->add(array(
            'name' => 'id',
            'required' => true,
            'filters' => array(
                array('name' => 'Int'),
            ),
        ));

        $this->add(array(
            'name' => 'nombre',
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
    }
}