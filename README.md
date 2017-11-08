# idp-pw-api-passwordstore-id-broker
Id Broker Password Store component for IdP PW API

[ ![Codeship Status for silinternational/idp-pw-api-passwordstore-id-broker](https://app.codeship.com/projects/54f3f840-f7ac-0134-c2f5-62bad16a2d4d/status?branch=master)](https://app.codeship.com/projects/210779)

## Configuration
This code is loaded in as a Yii2 Component in the main config file. Here is an example:

```php
'components' => [
    'passwordStore' => [
        'class' => 'Sil\IdpPw\PasswordStore\IdBroker\IdBroker',
        'baseUrl' => Env::requireEnv('ID_BROKER_BASE_URI'),
        'accessToken' => Env::requireEnv('ID_BROKER_ACCESS_TOKEN'),
        'assertValidBrokerIp' => true,
        'validIpRanges' => ['10.0.01/16','127.0.0.1/32'],
    ],
]
```

A more concise example:

```php
'components' => [
    'passwordStore' => ArrayHelper::merge(
        ['class' => 'Sil\IdpPw\PasswordStore\IdBroker\IdBroker'],
        Env::getArrayFromPrefix('ID_BROKER_')
    ),
]
```


## Composer / GitHub rate limit
If you hit problems of composer unable to pull the necessary dependencies
due to a GitHub rate limit, copy the `auth.json.dist` file to `auth.json` and
provide a GitHub auth token.
