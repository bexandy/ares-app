<?php
/**
 * Created by PhpStorm.
 * User: brodriguez
 * Date: 23/02/17
 * Time: 12:05 PM
 */

namespace Facturacion\Form;


use Zend\Form\Fieldset;

class DatosFacturaFieldset extends Fieldset
{
    public function __construct($name = null, $options = array())
    {
        parent::__construct($name, $options);

        $this->add(array(
            'name' => 'fecha',
            'type' => 'date',
            'options' => array(
                'label' => 'Fecha de la Factura'
            ),
            'attributes' => array(
                'id' => 'fecha',
            )
        ));

        $this->add(array(
            'name' => 'numfactura',
            'type' => 'text',
            'options' => array(
                'label' => 'N° de la Factura',
            ),
            'attributes' => array(
                'id' => 'numfactura',
                'required' => true,
                'maxlength' => 100,
            )
        ));

        $this->add(array(
            'name' => 'proveedor',
            'type' => 'text',
            'options' => array(
                'label' => 'Nombre del Proveedor',
            ),
            'attributes' => array(
                'id' => 'proveedor',
                'maxlength' => 100,
            )
        ));

        $this->add(array(
            'name' => 'lote',
            'type' => 'text',
            'options' => array(
                'label' => 'Código de Lote',
            ),
            'attributes' => array(
                'id' => 'lote',
                'maxlength' => 100,
            )
        ));
    }

}