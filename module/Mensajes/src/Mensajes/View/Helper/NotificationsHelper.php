<?php
/**
 * Created by PhpStorm.
 * User: brodriguez
 * Date: 05/02/17
 * Time: 10:20 PM
 */

namespace Mensajes\View\Helper;


use Zend\View\Helper\AbstractHelper;

class NotificationsHelper extends AbstractHelper
{
    public function __invoke()
    {
        echo $this->view->flashMessenger()->render('error',array('alert','alert-danger'));
        echo $this->view->flashMessenger()->render('success',array('success','alert-success'));
        echo $this->view->flashMessenger()->render('default',array('alert','alert-info'));
        // $this->view->flashMessenger()->clearCurrentMessagesFromNamespace('default');
        // $this->view->flashMessenger()->clearCurrentMessagesFromNamespace('success');
        // $this->view->flashMessenger()->clearCurrentMessagesFromNamespace('error');
    }
}
