<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of User
 *
 * @author criativa
 */

namespace Users\Model;

class User {
    
    public $id;
    public $name;
    public $password;
    public $email;
    
    public function setPassword($plain_password) {
        $this->password = md5($plain_password);
    }
    
    public function exchangeArray($data) {
        $this->name  = (isset($data['name']))  ? $data['name']  : null;
        $this->email = (isset($data['email'])) ? $data['email'] : null;
        if (isset($data['password'])) {
            $this->setPassword($data['password']);
        }
    }
}
