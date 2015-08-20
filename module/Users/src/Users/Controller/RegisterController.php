<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of RegisterController
 *
 * @author criativa
 */

namespace Users\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Users\Form\RegisterForm;
use Users\Form\RegisterFilter;
use Users\Model\User;
use Users\Model\UserTable;

class RegisterController extends AbstractActionController{
    
    public function indexAction() {
        $form = new RegisterForm();
        $viewModel = new ViewModel(['form' => $form]);
        return $viewModel;
    }
    
    public function confirmAction() {
        $viewModel = new ViewModel();
        return $viewModel;
    }
    
    public function processAction() {
        if (!$this->request->isPost()) {
            return $this->redirect()->toRoute(null,[
                'controller' => 'register',
                'action'     => 'index'
            ]);
        }
        
        $post = $this->request->getPost();
        $form = new RegisterForm();
        $inputFilter = new RegisterFilter();
        $form->setInputFilter($inputFilter);
        $form->setData($post);
        if (!$form->isValid()) {
            $model = new ViewModel([
                'error' => true,
                'form' => $form
            ]);
            $model->setTemplate('users/register/index');
            return $model;
        }
        $this->createUser($form->getData());
        return $this->redirect()->toRoute(null, [
            'controller' => 'register',
            'action'     => 'confirm'
        ]);
    }
    
    protected function createUser(array $data) {
        
        $sm                 = $this->getServiceLocator();
        $dbAdapter          = $sm->get('Zend\Db\Adapter\Adapter');
        $resultSetPrototype = new \Zend\Db\ResultSet\ResultSet();
        $resultSetPrototype->setArrayObjectPrototype(new User());
        $tableGateway       = new \Zend\Db\TableGateway\TableGateway('user', $dbAdapter, null, $resultSetPrototype);
        
        $user      = new User();
        $user->exchangeArray($data);
        $userTable = new UserTable($tableGateway);
        $userTable->saveUser($user);
        return true;
    }
}
