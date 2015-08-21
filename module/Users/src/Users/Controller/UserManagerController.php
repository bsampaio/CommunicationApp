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
    
}
