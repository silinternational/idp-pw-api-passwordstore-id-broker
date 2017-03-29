<?php
namespace Sil\IdpPw\PasswordStore\IdBroker\tests;

require __DIR__ . '/../vendor/autoload.php';

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
        $idBrokerForTest = Phake::mock(IdBroker::class);
        Phake::when($idBrokerForTest)->getMeta->thenCallParent();
        Phake::when($idBrokerForTest)->set->thenCallParent();
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
        $idbroker = $this->getIdBrokerForTest([]);
        
        $this->setExpectedException('\Sil\IdpPw\Common\PasswordStore\UserNotFoundException');
        
        $idbroker->getMeta('doesntexist');
    }

    public function testGetMetaAccountLocked()
    {
        $idbroker = $this->getClient();

//        $this->setExpectedException('\Sil\IdpPw\Common\PasswordStore\UserNotFoundException', '', 1463493653);
//        $idbroker->getMeta('doesntexist');
    }

    public function testSetOk()
    {
        $idbroker = $this->getClient();

//        $userMeta = $idbroker->set('10161', 'testpass');
//        $this->assertInstanceOf('\Sil\IdpPw\Common\PasswordStore\UserPasswordMeta', $userMeta);
    }

    public function testSetUserNotFound()
    {
        $idbroker = $this->getClient();

//        $this->setExpectedException('\Sil\IdpPw\Common\PasswordStore\UserNotFoundException', '', 1463493653);
//        $idbroker->getMeta('doesntexist');
    }

    public function testSetAccountLocked()
    {
        $idbroker = $this->getClient();

//        $this->setExpectedException('\Sil\IdpPw\Common\PasswordStore\AccountLockedException', '', 1472740480);
//        $userMeta = $idbroker->getMeta('10121');
    }

    /**
     * @return idbroker client
     */
    public function getClient()
    {
        $idbroker = new IdBroker();
        
//        $idbroker->host = '127.0.0.1';
//        $idbroker->port = 389;
//        $idbroker->baseDn = 'ou=gis_affiliated_person,dc=acme,dc=org';
//        $idbroker->adminUsername = 'cn=Manager,dc=acme,dc=org';
//        $idbroker->adminPassword = 'admin';
//        $idbroker->useTls = true;
//        $idbroker->useSsl = false;
//        $idbroker->employeeIdAttribute = 'gisEisPersonId';
//        $idbroker->passwordLastChangeDateAttribute = 'pwdchangedtime';
//        $idbroker->passwordExpireDateAttribute = 'modifytimestamp';
//        $idbroker->userPasswordAttribute = 'userPassword';
//        $idbroker->removeAttributesOnSetPassword = [
//            'pwdpolicysubentry',
//            'pwdaccountlockedtime',
//        ];
//        $idbroker->updateAttributesOnSetPassword = [
//            'gisusaeventpwdchange' => 'Yes'
//        ];
//        $idbroker->userAccountDisabledAttribute = 'pwdaccountlockedtime';
//        $idbroker->userAccountDisabledValue = '000001010000Z';
        
        return $idbroker;
    }
}