<?php
namespace Sil\IdpPw\PasswordStore\IdBroker\tests;

use Sil\IdpPw\Common\PasswordStore\UserPasswordMeta;
use Sil\IdpPw\PasswordStore\IdBroker\IdBroker;
use Phake;

class IdBrokerTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Get a mock IdBroker instance that will return user data from the given
     * array of users' information.
     *
     * @param array $listOfUserData
     * @return IdBroker
     */
    protected function getIdBrokerForTest($listOfUserData)
    {
        $fakeIdBrokerClient = new FakeIdBrokerClient($listOfUserData);
        $idBrokerForTest = Phake::partialMock(IdBroker::class);
        Phake::when($idBrokerForTest)->getClient()->thenReturn($fakeIdBrokerClient);
        return $idBrokerForTest;
    }
    
    public function testGetMetaOk()
    {
        $idbroker = $this->getIdBrokerForTest([
            '10161' => [
                'locked' => 'no',
                'password_expires' => time(),
                'password_last_changed' => time()
            ]
        ]);
        
        $userMeta = $idbroker->getMeta('10161');
        
        $this->assertInstanceOf(UserPasswordMeta::class, $userMeta);
        $this->assertNotNull($userMeta->passwordExpireDate);
    }
    
    public function testGetMetaUserNotFound()
    {
        $idbroker = $this->getIdBrokerForTest([
            '10161' => [
                'locked' => 'no',
                'password_expires' => time(),
                'password_last_changed' => time()
            ]
        ]);
        
        $this->setExpectedException('\Sil\IdpPw\Common\PasswordStore\UserNotFoundException');
        
        $idbroker->getMeta('badUserId');
    }
    
    public function testGetMetaAccountLocked()
    {
        $idbroker = $this->getIdBrokerForTest([
            '10161' => [
                'locked' => 'yes',
                'password_expires' => time(),
                'password_last_changed' => time()
            ]
        ]);
        
        $this->setExpectedException('\Sil\IdpPw\Common\PasswordStore\AccountLockedException');
        
        $userMeta = $idbroker->getMeta('10161');
    }
    
    public function testSetOk()
    {
        $idbroker = $this->getIdBrokerForTest([
            '10161' => [
                'locked' => 'no',
                'password_expires' => time(),
                'password_last_changed' => time()
            ]
        ]);
        
        $userMeta = $idbroker->set('10161', 'newPassword');
        
        $this->assertInstanceOf(UserPasswordMeta::class, $userMeta);
        $this->assertNotNull($userMeta->passwordExpireDate);
    }
    
    public function testSetUserNotFound()
    {
        $idbroker = $this->getIdBrokerForTest([
            '10161' => [
                'locked' => 'no',
                'password_expires' => time(),
                'password_last_changed' => time()
            ]
        ]);
        
        $this->setExpectedException('\Sil\IdpPw\Common\PasswordStore\UserNotFoundException');
        
        $idbroker->set('badUserId', 'newPassword');
    }
    
    public function testSetAccountLocked()
    {
        $idbroker = $this->getIdBrokerForTest([
            '10161' => [
                'locked' => 'yes',
                'password_expires' => time(),
                'password_last_changed' => time()
            ]
        ]);
        
        $this->setExpectedException('\Sil\IdpPw\Common\PasswordStore\AccountLockedException');
        
        $idbroker->set('10161', 'newPassword');
    }
}
