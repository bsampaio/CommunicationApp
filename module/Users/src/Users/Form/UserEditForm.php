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

class UserEditForm extends Form {
    
    public function __construct($name = null) {
        parent::__construct('UserEdit');
        $this->setAttribute('method', 'POST');
        $this->setAttribute('enctype', 'multipart/form-data');
        
        $this->add([
            'name'       => 'id',
            'attributes' => [
                'type' => 'hidden',
            ],
        ]);
        
        $this->add([
            'name'       => 'name',
            'attributes' => [
                'type' => 'text',
            ],
            'options'    => [
                'label' => 'Full Name',
            ],
        ]);
        
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
            'validators' => [
                [
                    'name'    => 'EmailAddress',
                    'options' => [
                        'messages' => [
                            \Zend\Validator\EmailAddress::INVALID_FORMAT =>  'Email address format is invalid'
                        ]
                    ]
                ]
            ]
            
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
            'validators' => [
                [
                    'name'    => 'StringLength',
                    'options' => [
                        'min' => 8,
                        'max' => 100
                    ]
                ]
            ]
        ]);
        
        $this->add([
            'name'       => 'confirm_password',
            'attributes' => [
                'type'      => 'Password',
                'required'  => 'required'
            ],
            'options'    => [
                'label' => 'Password Confirm'
            ],
            'filters'    => [
                
            ],
            'validators' => [
                [
                    'name'    => 'Identical',
                    'options' => [
                        'token' => 'password'
                    ]
                ]
            ]
        ]);
        
        $this->add([
            'name'       => 'submit',
            'attributes' => [
                'type'      => 'Submit',
                'value'     => 'Register'
            ],
            'options'    => [
                'label' => 'Submit'
            ],
        ]);
    }
}
