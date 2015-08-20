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
        $form = new LoginForm();
        $view = new ViewModel(['form' => $form]);
        $view->setTemplate('users/index/login');
        return $view;
    }
}
