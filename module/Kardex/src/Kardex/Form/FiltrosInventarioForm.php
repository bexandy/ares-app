<?php
/**
 * Created by PhpStorm.
 * User: brodriguez
 * Date: 13/02/17
 * Time: 12:12 AM
 */

namespace Kardex\Form;

use Kardex\Service\InventarioService;
use Zend\Form\Form;


class FiltrosInventarioForm extends Form
{
    protected $serviceLocator;
    protected $options;
    protected $inventarioService;
    protected $where;

    public function __construct(InventarioService $inventarioService, $where = array())
    {
        $this->inventarioService = $inventarioService;
        $this->where = $where;

        parent::__construct('filtros-inventario');

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

        $this->add(array(
            'type' => 'Zend\Form\Element\Select',
            'name' => 'categoria',
            'options' => array(
                'label' => 'Categoria: ',
                'required' => false,
                'empty_option' => 'Seleccione una Categoría',
                'value_options' => $this->getCategoriaForSelect(),
            ),
            'attributes' => array(
                'id' => 'categoria',
            )
        ));

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


    }

    public function getMarcaForSelect()
    {
        $options = $this->where;
        $idalmacen = array_key_exists('idalmacen',$options)?$options['idalmacen']:null;
        $idcategoria = array_key_exists('idcategoria',$options)?$options['idcategoria']:null;
        $inventarioService = $this->inventarioService;
        $marca = $inventarioService->getMarcasDisponibles($idalmacen,$idcategoria);
        $result    = $marca->toArray();

        $selectData = array();

        foreach ($result as $res) {
            $selectData[$res['id']] = $res['nombre'];
        }

        return $selectData;
    }

    public function getCategoriaForSelect()
    {
        $options = $this->where;
        $idalmacen = array_key_exists('idalmacen',$options)?$options['idalmacen']:null;
        $idmarca = array_key_exists('idmarca',$options)?$options['idmarca']:null;
        $inventarioService = $this->inventarioService;
        $categoria = $inventarioService->getCategoriasDisponibles($idalmacen,$idmarca);
        $result    = $categoria->toArray();

        $selectData = array();

        foreach ($result as $res) {
            $selectData[$res['id']] = $res['nombre'];
        }

        return $selectData;
    }

    public function getAlmacenForSelect()
    {
        $options = $this->where;
        $idmarca = array_key_exists('idmarca',$options)?$options['idmarca']:null;
        $idcategoria = array_key_exists('idcategoria',$options)?$options['idcategoria']:null;
        $inventarioService = $this->inventarioService;
        $almacen = $inventarioService->getAlmacenDisponibles($idmarca,$idcategoria);
        $result    = $almacen->toArray();

        $selectData = array();

        foreach ($result as $res) {
            $selectData[$res['id']] = $res['nombre'];
        }

        return $selectData;
    }


}