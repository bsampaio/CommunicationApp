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

class UserManagerController extends AbstractActionController {
    
    public function indexAction(){
        
        $sm = $this->getServiceLocator();
        $userTable = $sm->get('LoginForm');
        $viewModel = new ViewModel([
            'users' => $userTable->fetchAll()
        ]);
        return $viewModel;
    }
    
    public function editAction() {
        $sm        = $this->getServiceLocator();
        $userTable = $sm->get('UserTable');
        $user      = $userTable->getUser($this->params()->fromRoute('id'));
        $form      = $sm->get('UserEditForm');
        $form->bind($user);
        $viewModel = new ViewModel([
            'form'   => $form,
            'userId' => $this->params()->fromRoute('id')
        ]);
        return $viewModel;
    }
    
    public function proccessAction() {
        
        $sm         = $this->getServiceLocator();
        $post       = $this->request->getPost();
        $userTable  = $sm->get('UserTable');
        $user       = $userTable->getUser($post->id);
        $form       = $sm->get('UserEditForm');
        $form->bind($user);
        $form->setData($post);
        
        $sm->get('UserTable')->saveUser($user);
    }
    
    public function deleteAction() {
        $this->getServiceLocator()->get('UserTable')
                ->deleteUser($this->params()->fromRoute('id'));
    }
    
}
