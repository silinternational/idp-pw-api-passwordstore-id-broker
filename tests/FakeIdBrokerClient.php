<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Sil\IdpPw\PasswordStore\IdBroker\tests;

/**
 * Description of FakeIdBroker
 *
 * @author vail
 */
class FakeIdBrokerClient {
    private $users;
    
    public function __construct($users) 
    {
        $this->users = $users;
    }

    public function getUser($userInfo)
    {
        $employeeId = $userInfo['employee_id'] ?? null;
        if ($employeeId !== null) {
            return $this->users[$employeeId] ?? null;
        }
        return null;
    }
}
