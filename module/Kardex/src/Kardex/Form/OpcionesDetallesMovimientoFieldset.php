<?php
/**
 * Created by PhpStorm.
 * User: brodriguez
 * Date: 07/06/17
 * Time: 05:51 PM
 */

namespace Kardex\Form;


use Kardex\Model\OpcionesDetallesMovimientoEntity;
use Zend\Form\Fieldset;
use Zend\Stdlib\Hydrator\ClassMethods;

class OpcionesDetallesMovimientoFieldset extends Fieldset
{

    /**
     * OpcionesDetallesMovimientoFieldset constructor.
     */
    public function __construct($name = null, $options = array())
    {
        parent::__construct($name, $options);

        $this->setHydrator(new ClassMethods(false))
            ->setObject(new OpcionesDetallesMovimientoEntity());

        $this->add(array(
            'type' => 'radio',
            'name' => 'opcLote',
            'options' => array(
                'value_options' => array(
                    'individual' => '   Lotes individuales por cada ítem',
                    'nuevo' => '   Nuevo Lote  para todos los ítems',
                    'unico' => '   Único Lote  para todos los ítem'
                ),
            ),
            'attributes' => array(
                'id' => 'opcLote',
                'class' => 'radio-inline ui-checkboxradio radio-documento',
                'value' => 'individual'
            )
        ));

        $this->add(array(
            'type'  =>  'text',
            'name'  =>  'loteDefault',
            'attributes' => array(
                'readonly' => 'readonly',
                'disabled' => 'disabled',
                'id' =>  'loteDefault',
            ),
        ));

        $this->add(array(
            'type'  =>  'hidden',
            'name'  =>  'idLoteDefault',
            'attributes' => array(
                'id' => 'idLoteDefault',
            )
        ));
    }
}