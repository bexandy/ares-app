<?php
/**
 * Created by PhpStorm.
 * User: brodriguez
 * Date: 23/02/17
 * Time: 12:18 PM
 */

namespace Facturacion\Form;


use Zend\Form\Fieldset;

class DetallesFacturaFieldset extends Fieldset
{
    public function __construct($name = null, $options = array())
    {
        parent::__construct($name, $options);

        $this->add(array(
            'name' => 'producto',
            'type' => 'text',
            'options' => array(
                'label' => 'Producto',
            ),
            'attributes' => array(
                'id' => 'producto',
                'required' => true,
                'maxlength' => 100,
            )
        ));

        $this->add(array(
            'name' => 'precio',
            'type' => 'text',
            'options' => array(
                'label' => 'Precio',
            ),
            'attributes' => array(
                'id' => 'precio',
                'required' => true,
                'maxlength' => 100,
            )
        ));

        $this->add(array(
            'name' => 'cantidad',
            'type' => 'text',
            'options' => array(
                'label' => 'Cantidad',
            ),
            'attributes' => array(
                'id' => 'cantidad',
                'required' => true,
                'maxlength' => 100,
            )
        ));

        $this->add(array(
            'name' => 'unimed',
            'type' => 'text',
            'options' => array(
                'label' => 'Unidad Medida',
            ),
            'attributes' => array(
                'id' => 'unimed',
                'required' => true,
                'maxlength' => 100,
            )
        ));

        $this->add(array(
            'name' => 'fechavenc',
            'type' => 'text',
            'options' => array(
                'label' => 'Fecha Vencimiento',
            ),
            'attributes' => array(
                'id' => 'fechavenc',
                'required' => true,
                'maxlength' => 100,
            )
        ));


    }
}