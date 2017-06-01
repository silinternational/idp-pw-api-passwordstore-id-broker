<?php
namespace Sil\IdpPw\PasswordStore\IdBroker\tests;

class FakeIdBrokerClient
{
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
    
    public function setPassword($arrayOfUserInfo)
    {
        return $this->getUser($arrayOfUserInfo);
    }
}
