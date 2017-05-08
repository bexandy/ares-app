<?php
/**
 * Created by PhpStorm.
 * User: brodriguez
 * Date: 12/04/17
 * Time: 10:53 AM
 */

namespace Kardex\Form;


use Kardex\Service\FiltrosProductoService;
use Zend\Form\Form;

class FiltrosProductoForm extends Form
{
    protected $filtrosProductoService;
    protected $where;

    /**
     * FiltrosProductoForm constructor.
     * @param $where
     */
    public function __construct(FiltrosProductoService $filtrosProductoService, $where = array())
    {
        parent::__construct($name = null, $options = array());

        $this->filtrosProductoService = $filtrosProductoService;
        $this->where = $where;

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
    }

        public function getMarcaForSelect()
    {
        $options = $this->where;
        $idcategoria = array_key_exists('idcategoria',$options)?$options['idcategoria']:null;
        $filtrosProductoService = $this->filtrosProductoService;
        $marca = $filtrosProductoService->getMarcasDisponibles($idcategoria);
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
        $idmarca = array_key_exists('idmarca',$options)?$options['idmarca']:null;
        $filtrosProductoService = $this->filtrosProductoService;
        $categoria = $filtrosProductoService->getCategoriasDisponibles($idmarca);
        $result    = $categoria->toArray();

        $selectData = array();

        foreach ($result as $res) {
            $selectData[$res['id']] = $res['nombre'];
        }

        return $selectData;
    }


}