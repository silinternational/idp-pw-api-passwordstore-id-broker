<?php
namespace Sil\IdpPw\PasswordStore\IdBroker;

use IPBlock;
use Sil\Idp\IdBroker\Client\IdBrokerClient;
use Sil\IdpPw\Common\PasswordStore\AccountLockedException;
use Sil\IdpPw\Common\PasswordStore\PasswordStoreInterface;
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
     * @var boolean
     */
    public $assertValidBrokerIp = true;

    /**
     * @var IPBlock[]
     */
    public $validIpRanges = [];


    
    /**
     * Get metadata about user's password including last_changed_date and expires_date
     * @param string $employeeId
     * @return UserPasswordMeta
     * @throws \Exception
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
                $user['password']['expires_on'] ?? null,
                $user['password']['created_utc'] ?? null
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
                $update['password']['expires_on'] ?? null,
                $update['password']['created_utc'] ?? null
            );
            return $meta;
        } catch (\Exception $e) {
            throw $e;
        }
    }

    public function getClient()
    {
        return new IdBrokerClient($this->baseUrl, $this->accessToken, [
            IdBrokerClient::TRUSTED_IPS_CONFIG => $this->validIpRanges,
            IdBrokerClient::ASSERT_VALID_BROKER_IP_CONFIG => $this->assertValidBrokerIp,
        ]);
    }
}
