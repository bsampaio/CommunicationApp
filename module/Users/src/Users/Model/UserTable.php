<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of UserTable
 *
 * @author criativa
 */

namespace Users\Model;

use Zend\Db\Adapter\Adapter;
use Zend\Db\ResultSet\ResultSet;
use Zend\Db\TableGateway\TableGateway;

class UserTable {
    
    protected $tableGateway;
    public function __construct(TableGateway $tableGateway) {
        $this->tableGateway = $tableGateway;
    }
    
    public function saveUser(User $user) {
        $data = [
            'email'     => $user->email,
            'name'      => $user->name,
            'password'  => $user->password
        ];
        $id = (int) $user->id;
        if ($id == 0) {
            $this->tableGateway->insert($data);
        } else {
            if ($this->getUser($id)) {
                $this->tableGateway->update($data, ['id' => $id]);
            } else {
                throw new Exception('User ID does not exist');
            }
        }
    }
    
    public function getUser($id) {
        $id     = (int) $id;
        $rowset = $this->tableGateway->select(['id' => $id]);
        $row    = $rowset->current();
        if (!$row) {
            throw new Exception("Could not find row with id: $id");
        }
        
        return $row;
    }
    
    public function fetchAll() {
        $resultSet = $this->tableGateway->select();
        return $resultSet;
    }
    
    public function getUserByEmail($userEmail) {
        $rowSet = $this->tableGateway->select(['email' => $userEmail]);
        $row = $rowSet->current();
        if (!$row) {
            throw new \Exception("Could not find row with email: $userEmail");
        }
        
        return $row;
    }
    
    public function deleteUser($id) {
        $this->tableGateway->delete(['id' => $id]);
    }
}
