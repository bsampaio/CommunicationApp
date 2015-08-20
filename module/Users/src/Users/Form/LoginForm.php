<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of RegisterForm
 *
 * @author criativa
 */

namespace Users\Form;

use Zend\Form\Form;

class LoginForm extends Form{
    
    public function __construct($name = null) {
        parent::__construct('Register');
        $this->setAttribute('method', 'POST');
        $this->setAttribute('enctype', 'multipart/form-data');
        
        $this->add([
            'name'       => 'email',
            'attributes' => [
                'type'      => 'email',
                'required'  => 'required'
            ],
            'options'    => [
                'label' => 'Email'
            ],
            'filters'    => [
                ['name' => 'StringTrim'],
            ],
            
        ]);
        
        $this->add([
            'name'       => 'password',
            'attributes' => [
                'type'      => 'Password',
                'required'  => 'required'
            ],
            'options'    => [
                'label' => 'Password'
            ],
            'filters'    => [
                
            ],
        ]);
        
        $this->add([
            'name'       => 'submit',
            'attributes' => [
                'type'      => 'Submit',
                'value'     => 'Login'
            ],
            'options'    => [
                'label' => 'Submit'
            ],
        ]);
    }
}
