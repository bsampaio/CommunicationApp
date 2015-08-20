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

class IndexController extends AbstractActionController {
    
    public function indexAction() {
        $view = new ViewModel();
        return $view;
    }
    
    public function registerAction(){
        $view = new ViewModel();
        $view->setTemplate('users/index/new-user');
        return $view;
    }
    
    public function loginAction(){
        if($this->request->isGet()) {
            $form = new LoginForm();
            $view = new ViewModel(['form' => $form]);
            $view->setTemplate('users/index/login');
            return $view;
        } else if ($this->request->isPost()) {
            $post = $this->request->getPost();
            $form = new LoginForm();
            $inputFilter = new LoginFilter();
            $form->setInputFilter($inputFilter);
            $form->setData($post);
            if (!$form->isValid()) {
                $view = new ViewModel([
                    'error' => true,
                    'form' => $form
                ]);
                $view->setTemplate('users/index/login');
                return $view;
            }
            return $this->redirect()->toRoute(null, [
                'controller' => 'index',
                'action'     => 'login'
            ]);
            
        }
        
        return $this->redirect()->toRoute(null,[
            'controller' => 'index',
            'action'     => 'login'
        ]);
    }
}
