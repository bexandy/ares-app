<?php
/**
 * Created by PhpStorm.
 * User: brodriguez
 * Date: 10/04/17
 * Time: 09:19 AM
 */

namespace Kardex\Form;


use Zend\Form\Form;
use Zend\Stdlib\Hydrator\ClassMethods;

class DetallesLoteForm extends Form
{

    /**
     * DetalleLoteForm constructor.
     */
    public function __construct($name = null, $options = array())
    {
        parent::__construct($name, $options);

        $this->setAttribute('method', 'post');
        // $this->setInputFilter(new CategoriaFilter());
        $this->setHydrator(new ClassMethods());

        $this->add(array(
            'type'  =>  'hidden',
            'name'  =>  'id',
        ));

        $this->add(array(
            'type'  =>  'hidden',
            'name'  =>  'lote',
        ));

        $this->add(array(
            'type'  =>  'hidden',
            'name'  =>  'producto',
        ));

        $this->add(array(
            'type'  =>  'text',
            'name'  =>  'numlote',
            'options'   =>  array(
                'label' =>  'Número de Lote',
            ),
        ));

        $this->add(array(
            'type'  =>  'text',
            'name'  =>  'nombproducto',
            'options'   =>  array(
                'label' =>  'Nombre del Producto',
            ),
        ));

        $this->add(array(
            'type'  =>  'text',
            'name'  =>  'costo',
            'options'   =>  array(
                'label' =>  'Precio de Costo del Producto',
            ),
        ));

        $this->add(array(
            'type'  =>  'text',
            'name'  =>  'vencimiento',
            'options'   =>  array(
                'label' =>  'Fecha de Vencimiento del Producto',
            ),
            'attributes' => array(
                'id' => 'vencimiento',
            )
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