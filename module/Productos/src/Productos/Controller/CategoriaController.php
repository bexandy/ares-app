<?php
/**
 * Created by PhpStorm.
 * User: brodriguez
 * Date: 21/09/16
 * Time: 08:40 AM
 */

namespace Productos\Controller;

use Productos\Form\CategoriaForm;
use Productos\Form\FileUploadFilter;
use Productos\Model\CategoriaEntity;
use Zend\File\Transfer\Adapter\Http;
use Zend\Http\Request;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\Mvc\Router\RouteMatch;
use Zend\Validator\File\Size;
use Zend\View\Model\ViewModel;

class CategoriaController extends AbstractActionController
{
    public function indexAction()
    {
        $mapper = $this->getCategoriaMapper();
        $paginator = $mapper->fetchAll(true);
        $paginator->setCurrentPageNumber((int) $this->params()->fromQuery('page', 1));
        $paginator->setItemCountPerPage(8);

        return new ViewModel(array('paginator' => $paginator));
    }

    public function selectAction()
    {
        $id = $this->params('id');

        $request = $this->getRequest();
        $referer = $request->getHeader('referer');
        $refererUri = $referer->getUri();
        $refererRequest = new Request();
        $refererRequest->setUri($refererUri);
        $serviceManager = $this->getServiceLocator();
        $routeStack = $serviceManager->get('Router');
        $match = $routeStack->match($refererRequest);
        if ($match instanceof RouteMatch) {
            $route = $match->getMatchedRouteName();
            $urlaction = $match->getParam('action');
            $urlid = $match->getParam('id');
            $urlcat = $match->getParam('cat');
            $urldet = $match->getParam('det');
            $urlmay = $match->getParam('may');

        }
        if (is_null($urlid)) {$urlid = 0;}
        if (is_null($urlcat)) {$urlcat = 0;}
        if (is_null($urldet)) {$urldet = 0;}
        if (is_null($urlmay)) {$urlmay = 0;}

        $mapper = $this->getCategoriaMapper();
        return new ViewModel(array(
            'categorias' => $mapper->fetchAll(),
            'id' => $id,
            'urlroute' => $route,
            'urlaction' => $urlaction,
            'urlid' => $urlid,
            'urlcat' => $urlcat,
            'urldet' => $urldet,
            'urlmay' => $urlmay
        ));
    }

    public function getCategoriaMapper()
    {
        $sm = $this->getServiceLocator();
        return $sm->get('CategoriaMapper');
    }

    public function addAction()
    {
        $form = new CategoriaForm();
        $categoria = new CategoriaEntity();
        $form->bind($categoria);
        $fileUploadFilter = new FileUploadFilter();
        $form->setInputFilter($fileUploadFilter->getInputFilter());

        $request = $this->getRequest();
        if ($request->isPost()) {
            $File = $this->params()->fromFiles('fileupload');
            $data    = array_merge_recursive(
                $this->getRequest()->getPost()->toArray(),
                $this->getRequest()->getFiles()->toArray()
            );
            $form->setData($data);
            if ($form->isValid()) {
                $size = new Size(array('max' => 2000000));

                $adapter = new Http();
                $adapter->setValidators(array($size),$File['name']);
                $adapter->setOptions(array('ignoreNoFile'=>true));

                if (!$adapter->isValid())
                {
                    $dataError = $adapter->getMessages();
                    $error = array();
                    foreach ($dataError as $key => $row) {
                        $error[] = $row;
                    }
                    $form->setMessages(array('fileupload' => $error));
                } else {
                    if ($File['error'] !== 4) {
                        $adapter->setDestination(dirname(PUBLIC_PATH) . '/public/img/productos/tmp');
                        $tmp_pre = str_replace('/tmp/', '', $File['tmp_name']);
                        $file_name = $tmp_pre . '_' . $File['name'];
                        if ($adapter->receive($file_name)) {
                            $imagen = $adapter->getFileName();
                            $thumbnailer = $this->getServiceLocator()->get('WebinoImageThumb');
                            $thumb = $thumbnailer->create($imagen, $options = [], $plugins = []);

                            $thumb->adaptiveResize(100, 72);
                            $thumb_name = dirname(PUBLIC_PATH) . '/public/img/marcas/thumb_' . $File['name'];

                            $thumb->save($thumb_name);
                            $rutaImagen = str_replace(PUBLIC_PATH, '', $thumb_name);
                            $categoria->setImagen($rutaImagen);
                        }
                    }
                    $this->getCategoriaMapper()->saveCategoria($categoria);
                    return $this->redirect()->toRoute('categoria');
                }
            }
        }

        return array('form' => $form);
    }

    public function editAction()
    {
        $id = (int)$this->params('id');
        if (!$id) {
            return $this->redirect()->toRoute('categoria', array('action'=>'add'));
        }
        $categoria = $this->getCategoriaMapper()->getCategoria($id);

        $form = new CategoriaForm();
        $form->bind($categoria);
        $fileUploadFilter = new FileUploadFilter();
        $form->setInputFilter($fileUploadFilter->getInputFilter());

        $request = $this->getRequest();
        if ($request->isPost()) {
            $File = $this->params()->fromFiles('fileupload');
            $data = array_merge_recursive(
                $this->getRequest()->getPost()->toArray(),
                $this->getRequest()->getFiles()->toArray()
            );
            $form->setData($data);
            if ($form->isValid()) {
                $size = new Size(array('max' => 2000000));

                $adapter = new Http();
                $adapter->setValidators(array($size), $File['name']);
                $adapter->setOptions(array('ignoreNoFile' => true));

                if (!$adapter->isValid()) {
                    $dataError = $adapter->getMessages();
                    $error = array();
                    foreach ($dataError as $key => $row) {
                        $error[] = $row;
                    }
                    $form->setMessages(array('fileupload' => $error));
                } else {
                    if ($File['error'] !== 4) {
                        $adapter->setDestination(dirname(PUBLIC_PATH) . '/public/img/productos/tmp');
                        $tmp_pre = str_replace('/tmp/', '', $File['tmp_name']);
                        $file_name = $tmp_pre . '_' . $File['name'];
                        if ($adapter->receive($file_name)) {
                            $imagen = $adapter->getFileName();
                            $thumbnailer = $this->getServiceLocator()->get('WebinoImageThumb');
                            $thumb = $thumbnailer->create($imagen, $options = [], $plugins = []);

                            $thumb->adaptiveResize(100, 72);
                            $thumb_name = dirname(PUBLIC_PATH) . '/public/img/categorias/thumb_' . $File['name'];

                            $thumb->save($thumb_name);
                            $rutaImagen = str_replace(PUBLIC_PATH, '', $thumb_name);
                            $categoria->setImagen($rutaImagen);
                        }
                    }

                    $this->getCategoriaMapper()->saveCategoria($categoria);
                    return $this->redirect()->toRoute('categoria');
                }
            }
        }

        return array(
            'id' => $id,
            'form' => $form,
        );
    }

    public function deleteAction()
    {
        $id = $this->params('id');
        $categoria = $this->getCategoriaMapper()->getCategoria($id);
        if (!$categoria) {
            return $this->redirect()->toRoute('categoria');
        }

        $request = $this->getRequest();
        if ($request->isPost()) {
            if ($request->getPost()->get('del') == 'Yes') {
                $this->getCategoriaMapper()->deleteCategoria($id);
            }

            return $this->redirect()->toRoute('categoria');
        }

        return array(
            'id' => $id,
            'categoria' => $categoria
        );
    }
}