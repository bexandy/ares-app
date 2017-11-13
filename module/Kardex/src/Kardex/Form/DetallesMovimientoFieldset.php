<?php
/**
 * Created by PhpStorm.
 * User: brodriguez
 * Date: 04/05/17
 * Time: 03:50 PM
 */

namespace Kardex\Form;


use Kardex\Model\DetallesMovimientoEntity;
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
        $this->setHydrator(new ClassMethods(false))
            ->setObject(new DetallesMovimientoEntity());

        $this->add(array(
            'type'  =>  'hidden',
            'name'  =>  'id',
        ));

        $this->add(array(
            'type'  =>  'hidden',
            'name'  =>  'movimiento',
            'attributes' => array(
                'required' => true,
            )
        ));

        $this->add(array(
            'type'  =>  'hidden',
            'name'  =>  'producto',
            'attributes' => array(
                'required' => true,
            )
        ));

        $this->add(array(
            'type'  =>  'hidden',
            'name'  =>  'lote',
        ));

        $this->add(array(
            'type'  =>  'hidden',
            'name'  =>  'um',
            'attributes' => array(
                'required' => true,
            )
        ));

        $this->add(array(
            'type'  =>  'text',
            'name'  =>  'numlote',
            'attributes' => array(
                'placeholder' => 'Lote',
                'required' => true,
                'readonly' => 'readonly',
                'size' => 18,
                'class' => 'detalle-ingreso'
            )
        ));

        $this->add(array(
            'type'  =>  'text',
            'name'  =>  'nombproducto',
            'attributes' => array(
                'placeholder' => 'Producto',
                'required' => true,
                'readonly' => 'readonly',
                'size' => 30,
                'class' => 'detalle-ingreso'
            )
        ));

        $this->add(array(
            'type'  =>  'text',
            'name'  =>  'cantidad',
            'attributes' => array(
                'placeholder' => 'Cantidad',
                'required' => true,
                'size' => 5,
                'class' => 'detalle-ingreso'
            )
        ));

        $this->add(array(
            'type'  =>  'text',
            'name'  =>  'unidadmedida',
            'attributes' => array(
                'placeholder' => 'UM',
                'required' => true,
                'readonly' => 'readonly',
                'size' => 5,
                'class' => 'detalle-ingreso'
            )
        ));

        $this->add(array(
            'type'  =>  'text',
            'name'  =>  'costo',
            'attributes' => array(
                'placeholder' => 'Precio',
                'required' => true,
                'size' => 10,
                'class' => 'detalle-ingreso'
            )
        ));

        $this->add(array(
            'type'  =>  'text',
            'name'  =>  'vencimiento',
            'attributes' => array(
                'placeholder' => 'FVenc',
                'readonly' => 'readonly',
                'size' => 10,
                'class' => 'detalle-ingreso datepicker'
            )
        ));

    }
}