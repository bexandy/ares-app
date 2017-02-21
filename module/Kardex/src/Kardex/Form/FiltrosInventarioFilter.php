<?php
/**
 * Created by PhpStorm.
 * User: brodriguez
 * Date: 13/02/17
 * Time: 12:15 AM
 */

namespace Kardex\Form;


use Zend\InputFilter\InputFilter;

class FiltrosInventarioFilter extends InputFilter
{

    function __construct()
    {
        $this->add(array(
            'name' => 'categoria',
            'required' => false,
            'allowEmpty' => true,
        ));

        $this->add(array(
            'name' => 'marca',
            'required' => false,
            'allowEmpty' => true,
        ));

        $this->add(array(
            'name' => 'almacen',
            'required' => false,
            'allowEmpty' => true,
        ));
    }
}