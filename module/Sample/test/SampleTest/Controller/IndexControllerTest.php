<?php
/**
 * Created by PhpStorm.
 * User: brodriguez
 * Date: 11/02/17
 * Time: 06:23 PM
 */

namespace SampleTest\Controller;


use Zend\Test\PHPUnit\Controller\AbstractHttpControllerTestCase;

class IndexControllerTest extends AbstractHttpControllerTestCase
{
    protected $traceError = true;

    public function setUp()
    {
        $this->setApplicationConfig(
            include '/var/www/ares-app/config/application.config.php'
        );
        parent::setUp();

        // Creating mock
        //$mockBjy = $this->getMock("BjyAuthorize\Service\Authorize", array("isAllowed"), array($this->getApplicationConfig(), $this->getApplication()->getServiceManager()));
        $mockBjy = $this->getMockBuilder('BjyAuthorize\Service\Authorize')
                        ->setConstructorArgs(array($this->getApplicationConfig(), $this->getApplication()->getServiceManager()))
                        ->setMethods(array('isAllowed'))
                        ->getMock();
        // Bypass auth, force true
        $mockBjy->expects($this->any())
            ->method('isAllowed')
            ->will($this->returnValue(true));

        // Overriding BjyAuthorize\Service\Authorize service
        $this->getApplication()
            ->getServiceManager()
            ->setAllowOverride(true)
            ->setService('BjyAuthorize\Service\Authorize', $mockBjy);

    }

    public function testIndexActionCanBeAccesed()
    {
        //$this->login('autenticado');
        $this->dispatch('/sample');
        $this->assertResponseStatusCode(200);

        $this->assertModuleName('Sample');
        $this->assertControllerName('Sample\Controller\Index');
        $this->assertControllerClass('IndexController');
        $this->assertMatchedRouteName('sample');
    }

    protected function login($roles) {

        $authorizeMock = $this->getMockBuilder('BjyAuthorize\Provider\Identity\ZfcUserZendDb')
                                ->disableOriginalConstructor()
                                ->getMock();

        $authorizeMock->expects($this->once())
                    ->method('getIdentityRoles')
                    ->will($this->returnValue($roles));
        /*
        $userMock = $this->getMock('Application\Entity\User', [], [], '', false);
        $userMock->expects($this->any())
            ->method('getRoles')->will($this->returnValue($roles));

        $storageMock = $this->getMock('\Zend\Authentication\Storage\NonPersistent');
        $storageMock->expects($this->any())
            ->method('isEmpty')->will($this->returnValue(false));
        $storageMock->expects($this->any())
            ->method('read')->will($this->returnValue($userMock));
        */

        $sm = $this->getApplicationServiceLocator();
        $auth = $sm->get('BjyAuthorize\Service\Authorize');
        $auth->setStorage($authorizeMock);
    }
}
