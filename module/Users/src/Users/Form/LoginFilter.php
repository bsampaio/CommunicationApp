<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of RegisterFilter
 *
 * @author criativa
 */

namespace Users\Form;

use Zend\InputFilter\InputFilter;

class LoginFilter extends InputFilter {
    
    public function __construct() {
        
        $this->add(array(
            'name'       => 'email',
            'required'   => true,
            'validators' => array(
                array(
                    'name'    => 'EmailAddress',
                    'options' => array(
                        'domain' => true,
                    ),
                ),
            ),
        ));
        
        $this->add(array(
            'name'       => 'password',
            'required'   => true,
        ));
    }
}
