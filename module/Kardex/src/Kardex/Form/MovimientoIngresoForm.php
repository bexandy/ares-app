<?php
/**
 * Created by PhpStorm.
 * User: brodriguez
 * Date: 03/05/17
 * Time: 06:50 PM
 */

namespace Kardex\Form;


use Almacen\Model\AlmacenMapper;
use Zend\Form\Form;

class MovimientoIngresoForm extends Form
{
    protected $almacenMapper;
    /**
     * MovimientoIngresoForm constructor.
     */
    public function __construct(AlmacenMapper $almacenMapper, $name = null, $options = array())
    {

        parent::__construct($name, $options);
        $this->almacenMapper = $almacenMapper;

        $movimientoIngresoFieldset = new \Kardex\Form\MovimientoIngresoFieldset($this->almacenMapper);
        $movimientoIngresoFieldset->setName('MovimientoIngreso');
        //$movimientoIngresoFieldset->setOption('use_as_base_fieldset',true);
        //$movimientoIngresoFieldset->setOptions(array('use_as_base_fieldset' => true));
        $movimientoIngresoFieldset->setUseAsBaseFieldset(true);



        $this->add($movimientoIngresoFieldset);

/*
        $this->add(array(
            'name' => 'MovimientoIngreso',
            'type' => new \Kardex\Form\MovimientoIngresoFieldset($this->almacenMapper),
            'options' => array(
                'useAsBaseFieldset' => true
            )

        ));
*/
        $this->add(array(
            'name' => 'submit',
            'attributes' => array(
                'type'  => 'submit',
                'value' => 'Crear Ingreso',
                'class' => 'btn btn-primary',
            ),
        ));
    }

}