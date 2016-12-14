<?php
/**
 * Created by PhpStorm.
 * User: brodriguez
 * Date: 04/12/16
 * Time: 09:58 PM
 */

namespace Usuarios\Controller;


use Application\Entity\User;
use HtProfileImage\Service\ProfileImageServiceInterface;
use Negotiation\FormatNegotiator;
use Usuarios\Form\CrearUsuarioFilter;
use Usuarios\Form\EditarUsuarioForm;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\Paginator\Adapter\ArrayAdapter;
use Zend\Paginator\Paginator;
use Zend\View\Model\ViewModel;
use ZfcUser\Options\ModuleOptions;

class UsuariosController extends AbstractActionController
{
    protected $options, $userMapper, $optionsImage;
    protected $zfcUserOptions;
    protected $adminUserService;
    protected $profileImageService;
    protected $roleMapper;
    protected $usuarioMapper;
    protected $rolesMapper;



    public function __construct()
    {

    }

    public function indexAction()
    {
        $usuarioMapper = $this->getUsuarioMapper();
        $users = $usuarioMapper->fetchAll();

        $users->buffer();
        foreach ($users as $user){
            $roles = $this->getMyRoleMapper()->getRolesById($user->getId());
            $user->addRole($roles);
        }

        return array(
            'users' => $users,
        );
    }

    public function getMyRoleMapper()
    {
        if (null === $this->rolesMapper) {
            $this->rolesMapper = $this->getServiceLocator()->get('RoleMapper');
        }
        return $this->rolesMapper;
    }

    public function getUsuarioMapper()
    {
        if (null === $this->usuarioMapper) {
            $this->usuarioMapper = $this->getServiceLocator()->get('UsuarioMapper');
        }
        return $this->usuarioMapper;
    }

    public function editAction()
    {
        $userId = $this->getEvent()->getRouteMatch()->getParam('userId');
        $user = $this->getUsuarioMapper()->findById($userId);

        $formulario = $this->getServiceLocator()->get('EditarUsuarioForm');
        $formulario->bind($user);
        $formulario->get('rolId')->setValue(null);
        $roles = $this->getMyRoleMapper()->getRolesById($user->getId());
        $id = $roles->getId();
        $formulario->get('select_roles')->setValue($id);
        $formulario->get('rolId')->setValue($id);
        $formImage = $this->getServiceLocator()->get('HtProfileImage\ProfileImageForm');

        $request = $this->getRequest();
        $imageUploaded = false;
        if ($request->isPost()) {
            $submit = $request->getPost()->get('submit');
            if ($submit === 'Upload'){
                $negotiator   = new FormatNegotiator();
                $format = $negotiator->getBest(
                    $request->getHeader('Accept')->getFieldValue(),
                    ['application/json', 'text/html']
                );
                $profileImageService = $this->getServiceLocator()->get('HtProfileImage\Service\ProfileImageService');
                $this->profileImageService = $profileImageService;
                if ($this->profileImageService->storeImage($user, $request->getFiles()->toArray())) {
                    if ($format->getValue() === 'application/json') {
                        return new Model\JsonModel([
                            'uploaded' => true
                        ]);
                    } else {
                        $formulario->populateFromUser($user);
                        $imageUploaded = true;
                        return array(
                            'editUserForm' => $formulario,
                            'userId' => $userId,
                            'formImage' => $formImage,
                            'imageUploaded' => $imageUploaded,
                        );
                    }
                    $imageUploaded = true;
                } else {
                    $response = $this->getResponse();
                    /** @var \Zend\Http\Response $response */
                    $response->setStatusCode(400);
                    if ($format->getValue() === 'application/json') {
                        return new Model\JsonModel([
                            'error' => true,
                            'messages' => $form->getMessages()
                        ]);
                    }

                }
            }

            if ($submit === 'Guardar'){
                $formulario->setData($request->getPost());
                if ($formulario->isValid()) {
                    if ($request->getPost()->get('password') === ""){
                        $user->setPassword(null);
                    }
                    $user = $this->getUsuarioMapper()->edit($formulario, (array)$request->getPost(), $user);
                    if ($user) {
                        $rolId = $request->getPost()->get('rolId');
                        $roleId = $this->getMyRoleMapper()->getRoleId($rolId);
                        $userId =$user->getId();

                        $this->getMyRoleMapper()->update($userId, $roleId);

                        $user->addRole($rolId);
                        $this->flashMessenger()->addSuccessMessage('El Usuario fue editado');
                        return $this->redirect()->toRoute('usuarios');
                    }
                }
            }

        } else {
            $formulario->populateFromUser($user);
        }

        return array(
            'editUserForm' => $formulario,
            'userId' => $userId,
            'formImage' => $formImage,
            'imageUploaded' => $imageUploaded,
        );
    }

    public function createAction()
    {
        $user = new User();

        $formulario = $this->getServiceLocator()->get('EditarUsuarioForm');
        $formulario->setInputFilter(new CrearUsuarioFilter());
        $formulario->bind($user);
        $formulario->get('rolId')->setValue(null);
        $formImage = $this->getServiceLocator()->get('HtProfileImage\ProfileImageForm');

        $request = $this->getRequest();
        $imageUploaded = false;

        if ($request->isPost()) {
            $submit = $request->getPost()->get('submit');

            if ($submit === 'Upload'){
                $negotiator   = new FormatNegotiator();
                $format = $negotiator->getBest(
                    $request->getHeader('Accept')->getFieldValue(),
                    ['application/json', 'text/html']
                );
                $profileImageService = $this->getServiceLocator()->get('HtProfileImage\Service\ProfileImageService');
                $this->profileImageService = $profileImageService;
                if ($this->profileImageService->storeImage($user, $request->getFiles()->toArray())) {
                    if ($format->getValue() === 'application/json') {
                        return new Model\JsonModel([
                            'uploaded' => true
                        ]);
                    } else {
                        $formulario->populateFromUser($user);
                        $imageUploaded = true;
                        return array(
                            'editUserForm' => $formulario,
                            'formImage' => $formImage,
                            'imageUploaded' => $imageUploaded,
                        );
                    }
                    $imageUploaded = true;
                } else {
                    $response = $this->getResponse();
                    /** @var \Zend\Http\Response $response */
                    $response->setStatusCode(400);
                    if ($format->getValue() === 'application/json') {
                        return new Model\JsonModel([
                            'error' => true,
                            'messages' => $form->getMessages()
                        ]);
                    }

                }
            }

            if ($submit === 'Guardar'){
                $formulario->setData($request->getPost());
                if ($formulario->isValid()) {
                    if ($request->getPost()->get('password') === ""){
                        $user->setPassword(null);
                    }
                    $user = $this->getUsuarioMapper()->edit($formulario, (array)$request->getPost(), $user);
                    if ($user) {
                        $rolId = $request->getPost()->get('rolId');
                        $roleId = $this->getMyRoleMapper()->getRoleId($rolId);
                        $userId =$user->getId();

                        $this->getMyRoleMapper()->save($userId, $roleId);

                        $user->addRole($rolId);
                        $this->flashMessenger()->addSuccessMessage('El Usuario fue editado');
                        return $this->redirect()->toRoute('usuarios');
                    }
                }
            }

        }

        return array(
            'editUserForm' => $formulario,
            'formImage' => $formImage,
            'imageUploaded' => $imageUploaded,
        );
    }
}