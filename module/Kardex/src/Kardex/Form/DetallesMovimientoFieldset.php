<?php
/**
 * Created by PhpStorm.
 * User: brodriguez
 * Date: 04/05/17
 * Time: 03:50 PM
 */

namespace Kardex\Form;


use Zend\Form\Fieldset;
use Zend\Stdlib\Hydrator\ClassMethods;

class DetallesMovimientoFieldset extends Fieldset
{

    /**
     * DetallesMovimientoFieldset constructor.
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
            'name'  =>  'movimiento',
        ));

        $this->add(array(
            'type'  =>  'hidden',
            'name'  =>  'producto',
        ));

        $this->add(array(
            'type'  =>  'hidden',
            'name'  =>  'lote',
        ));

        $this->add(array(
            'type'  =>  'text',
            'name'  =>  'cantidad',
            'options'   =>  array(
                'label' =>  'Cantidad del Producto',
            ),
        ));

        $this->add(array(
            'type'  =>  'text',
            'name'  =>  'unidadmedida',
            'options'   =>  array(
                'label' =>  'Unidad de Medida',
            ),
            'attributes' => array(
                'id' => 'unidadmedida',
            )
        ));
    }
}