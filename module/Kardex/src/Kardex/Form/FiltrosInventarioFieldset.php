<?php
/**
 * Created by PhpStorm.
 * User: brodriguez
 * Date: 13/02/17
 * Time: 12:08 AM
 */

namespace Kardex\Form;


use Kardex\Service\InventarioService;
use Zend\Form\Fieldset;

class FiltrosInventarioFieldset extends Fieldset
{
    protected $inventarioService;

    public function __construct(InventarioService $inventarioService)
    {
        parent::__construct('form-inventario-fieldset');

        $this->inventarioService = $inventarioService;
/*
        $this->add(array(
            'type' => 'Zend\Form\Element\Select',
            'name' => 'categoria',
            'options' => array(
                'label' => 'Categoria: ',
                'required' => false,
                'empty_option' => 'Seleccione una Categoría',
                'value_options' => $this->getCategoryForSelect(),
            ),
            'attributes' => array(
                'id' => 'categoria',
            )
        ));
*/
        $this->add(array(
            'type' => 'Zend\Form\Element\Select',
            'name' => 'marca',
            'options' => array(
                'label' => 'Marca: ',
                'required' => false,
                'empty_option' => 'Seleccione una Marca',
                'value_options' => $this->getMarcaForSelect(),
            ),
            'attributes' => array(
                'id' => 'marca',
            )
        ));
/*
        $this->add(array(
            'type' => 'Zend\Form\Element\Select',
            'name' => 'almacen',
            'options' => array(
                'label' => 'Almacen: ',
                'required' => false,
                'empty_option' => 'Seleccione un Almacén',
                'value_options' => $this->getAlmacenForSelect(),
            ),
            'attributes' => array(
                'id' => 'almacen',
            )
        ));
*/
    }

    public function getCategoryForSelect()
    {
/*
        $inventarioService = $this->inventarioService;
        $category = $inventarioService->getMarcasDisponibles();
        $result    = $category->toArray();

        $selectData = array();

        foreach ($result as $res) {
            $selectData[$res['id']] = $res['nombre'];
        }
*/
        $selectData = array();
        return $selectData;
    }

    public function getMarcaForSelect()
    {

        $inventarioService = $this->inventarioService;
        $marca = $inventarioService->getMarcasDisponibles();
        $result    = $marca->toArray();

        $selectData = array();

        foreach ($result as $res) {
            $selectData[$res['id']] = $res['nombre'];
        }

        return $selectData;
    }

    public function getAlmacenForSelect()
    {
       // $inventarioService = $this->inventarioService;
       // $almacen = $inventarioService->getMarcasDisponibles();
       // $result    = $almacen->toArray();

        $selectData = array();

        //foreach ($result as $res) {
        //    $selectData[$res['id']] = $res['nombre'];
       // }
        return $selectData;
    }

}