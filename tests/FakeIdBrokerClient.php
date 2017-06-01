<?php
namespace Sil\IdpPw\PasswordStore\IdBroker\tests;

class FakeIdBrokerClient
{
    private $users;
    
    public function __construct($users) 
    {
        $this->users = $users;
    }
    
    public function getUser($employeeId)
    {
        if ($employeeId !== null) {
            return $this->users[$employeeId] ?? null;
        }
        return null;
    }
    
    public function setPassword($employeeId, $password)
    {
        return $this->getUser($employeeId);
    }
}
