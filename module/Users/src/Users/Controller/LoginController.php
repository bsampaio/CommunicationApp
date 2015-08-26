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

class LoginController extends AbstractActionController {
    
    public function indexAction(){
        
        $sm = $this->getServiceLocator();
        $form = $this->getServiceLocator()->get('LoginForm');
        if($this->request->isGet()) {
            $view = new ViewModel(['form' => $form]);
            $view->setTemplate('users/login/index');
            return $view;
        } else if ($this->request->isPost()) {
            $post = $this->request->getPost();
            $inputFilter = $sm->get('LoginFilter');
            $form->setInputFilter($inputFilter);
            $form->setData($post);
            
            $authService = $this->getServiceLocator()->get('AuthService');
            $authService->getAdapter()
                    ->setIdentity($this->request->getPost('email'))
                    ->setCredential($this->request->getPost('password'));
            $result = $authService->authenticate();
            
            if (!$form->isValid()) {
                $view = new ViewModel([
                    'error' => true,
                    'form' => $form
                ]);
                $view->setTemplate('users/login/index');
                return $view;
            }
            
            if ($result->isValid()) {
                $authService->getStorage()->write($this->request->getPost('email'));
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
        $userEmail = $this->getServiceLocator()->get('AuthService')
                        ->getStorage()->read();
        $viewModel = new ViewModel([
            'userEmail' => $userEmail
        ]);
        return $viewModel;
    }
    
}
