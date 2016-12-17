<?php
/**
 * Created by PhpStorm.
 * User: brodriguez
 * Date: 15/12/16
 * Time: 05:59 PM
 */

namespace Productos\Form;


use Zend\Form\Form;
use Zend\Stdlib\Hydrator\ClassMethods;

class MarcaForm extends Form
{
    public function __construct($name = null, $options = array())
    {
        parent::__construct('marca');

        $this->setAttribute('method', 'post');
        $this->setAttribute('enctype','multipart/form-data');
        $this->setInputFilter(new MarcaFilter());
        $this->setHydrator(new ClassMethods());

        $this->add(array(
            'type'  =>  'hidden',
            'name'  =>  'id',
        ));

        $this->add(array(
            'type'  =>  'text',
            'name'  =>  'nombre',
            'options'   =>  array(
                'label' =>  'Nombre de la Marca',
            ),
        ));

        $this->add(array(
            'name' => 'fileupload',
            'attributes' => array(
                'type'  => 'file',
                'id' => 'fileupload',
            ),
            'options' => array(
                'label' => 'Subir Imagen',
                'ignoreNoFile' => true,
            ),
        ));

        $this->add(array(
            'type'  =>  'hidden',
            'name'  =>  'imagen',
            'options'   =>  array(
                'label' =>  'Ruta de la Foto de la Marca',
            ),
            'attributes' => array(
                'id' => 'imagen',
                'maxlength' => 100,
                'class' => 'form-control',
            )
        ));

        $this->add(array(
            'name' => 'submit',
            'attributes' => array(
                'type'  => 'submit',
                'value' => 'Go',
                'class' => 'btn btn-primary',
            ),
        ));
    }

}