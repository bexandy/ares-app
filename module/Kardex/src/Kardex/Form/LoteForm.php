<?php
/**
 * Created by PhpStorm.
 * User: brodriguez
 * Date: 10/04/17
 * Time: 10:37 AM
 */

namespace Kardex\Form;


use Zend\Form\Form;
use Zend\Stdlib\Hydrator\ClassMethods;

class LoteForm extends Form
{

    /**
     * LoteForm constructor.
     */
    public function __construct($name = null, $options = array())
    {
        parent::__construct($name = null, $options = array());

        $this->setAttribute('method', 'post');
        // $this->setInputFilter(new CategoriaFilter());
        $this->setHydrator(new ClassMethods());

        $this->add(array(
            'type'  =>  'hidden',
            'name'  =>  'id',
        ));

        $this->add(array(
            'type'  =>  'text',
            'name'  =>  'numlote',
            'options'   =>  array(
                'label' =>  'Número de Lote',
            ),
        ));
    }
}