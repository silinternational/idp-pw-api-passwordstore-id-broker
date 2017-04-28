<?php
namespace Sil\IdpPw\PasswordStore\IdBroker;

use Sil\Idp\IdBroker\Client\IdBrokerClient;
use Sil\IdpPw\Common\PasswordStore\AccountLockedException;
use Sil\IdpPw\Common\PasswordStore\PasswordStoreInterface;
use Sil\IdpPw\Common\PasswordStore\PasswordReuseException;
use Sil\IdpPw\Common\PasswordStore\UserNotFoundException;
use Sil\IdpPw\Common\PasswordStore\UserPasswordMeta;
use yii\base\Component;

class IdBroker extends Component implements PasswordStoreInterface
{
    /**
     * @var string base Url for the API
     */
    public $baseUrl;
    
    /**
     * @var string access Token for the API
     */
    public $accessToken;

    /**
     * Get metadata about user's password including last_changed_date and expires_date
     * @param string $employeeId
     * @return \Sil\IdpPw\Common\PasswordStore\UserPasswordMeta
     * @throw \Sil\IdpPw\Common\PasswordStore\UserNotFoundException
     * @throw \Sil\IdpPw\Common\PasswordStore\AccountLockedException
     */
    public function getMeta($employeeId)
    {
        try {        
            $client = $this->getClient();

            $user = $client->getUser($employeeId);
            
            if ($user === null) {
                throw new UserNotFoundException();
            }
            
            if ($user['locked'] == 'yes') {
                throw new AccountLockedException();
            }
            
            $meta = UserPasswordMeta::create(
                    $user['password_expires'], 
                    $user['password_last_changed']
            );
            return $meta;
        } catch (\Exception $e) {
            throw $e;
        }
    }

    /**
     * Set user's password
     * @param string $employeeId
     * @param string $password
     * @return \Sil\IdpPw\Common\PasswordStore\UserPasswordMeta
     * @throws \Exception
     * @throw \Sil\IdpPw\Common\PasswordStore\UserNotFoundException
     * @throw \Sil\IdpPw\Common\PasswordStore\AccountLockedException
     */
    public function set($employeeId, $password)
    {
        try {        
            $client = $this->getClient();

            $user = $client->getUser($employeeId);
            
            if ($user === null) {
                throw new UserNotFoundException();
            }
            
            if ($user['locked'] == 'yes') {
                throw new AccountLockedException();
            }
            
            $update = $client->setPassword($employeeId, $password);
            
            $meta = UserPasswordMeta::create(
                    $update['password_expires'], 
                    $update['password_last_changed']
            );
            return $meta;
        } catch (\Exception $e) {
            throw $e;
        }
    }
    
    public function getClient() 
    {
        return new IdBrokerClient($this->baseUrl, $this->accessToken);
    }
}