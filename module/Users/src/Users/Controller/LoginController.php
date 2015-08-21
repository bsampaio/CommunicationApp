<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of IndexController
 *
 * @author Breno Grillo
 */

namespace Users\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Users\Form\LoginForm;
use Users\Form\LoginFilter;
use Zend\Authentication\Adapter\DbTable as DbTableAuthAdapter;
use Zend\Authentication\AuthenticationService;

class LoginController extends AbstractActionController {
    
    protected $authService;

    public function indexAction(){
        if($this->request->isGet()) {
            $form = new LoginForm();
            $view = new ViewModel(['form' => $form]);
            $view->setTemplate('users/login/index');
            return $view;
        } else if ($this->request->isPost()) {
            $post = $this->request->getPost();
            $form = new LoginForm();
            $inputFilter = new LoginFilter();
            $form->setInputFilter($inputFilter);
            $form->setData($post);
            $this->getAuthService()->getAdapter()
                    ->setIdentity($this->request->getPost('email'))
                    ->setCredential($this->request->getPost('password'));
            $result = $this->getAuthService()->authenticate();
            
            if (!$form->isValid()) {
                $view = new ViewModel([
                    'error' => true,
                    'form' => $form
                ]);
                $view->setTemplate('users/login/index');
                return $view;
            }
            
            if ($result->isValid()) {
                $this->getAuthService()->getStorage()->write($this->request->getPost('email'));
                return $this->redirect()->toRoute(NULL, [
                    'controller' => 'login',
                    'action'     => 'confirm'
                ]);
            } 
        }
        
        return $this->redirect()->toRoute(null,[
            'controller' => 'login',
            'action'     => 'index'
        ]);
    }
    
    public function confirmAction() {
        $userEmail = $this->getAuthService()->getStorage()->read();
        $viewModel = new ViewModel([
            'userEmail' => $userEmail
        ]);
        return $viewModel;
    }
    
    public function getAuthService() {
        if (! $this->authService) {
            $dbAdapter = $this->getServiceLocator()->get('Zend\Db\Adapter\Adapter');
            $dbTableAuthAdapter = new DbTableAuthAdapter($dbAdapter, 'user', 'email', 'password', 'MD5(?)');
            $authService = new AuthenticationService();
            $authService->setAdapter($dbTableAuthAdapter);
            $this->authService = $authService;
        }
        
        return $this->authService;
    }
}
