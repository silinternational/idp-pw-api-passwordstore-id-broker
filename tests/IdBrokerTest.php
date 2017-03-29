<?php
namespace tests;

require __DIR__ . '/../vendor/autoload.php';

use Sil\IdpPw\PasswordStore\IdBroker\IdBroker;

class IdBrokerTest extends \PHPUnit_Framework_TestCase
{
    public function testGetMetaOk()
    {
        $idbroker = $this->getClient();

//        $userMeta = $idbroker->getMeta('10161');
//        $this->assertInstanceOf('\Sil\IdpPw\Common\PasswordStore\UserPasswordMeta', $userMeta);
//        $this->assertNotNull($userMeta->passwordExpireDate);
    }

    public function testGetMetaUserNotFound()
    {
        $idbroker = $this->getClient();

//        $this->setExpectedException('\Sil\IdpPw\Common\PasswordStore\UserNotFoundException', '', 1463493653);
//        $idbroker->getMeta('doesntexist');
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