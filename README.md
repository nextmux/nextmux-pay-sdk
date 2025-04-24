```bash
composer require nextmux/pay-sdk
```

```php
use Nextmux\PaySDK\ApiClient;
use Nextmux\PaySDK\NextmuxPay;
use Nextmux\PaySDK\PayIn;


$nmpay = NextmuxPay::init(['publicKey' => 'PUBLIC_KEY', 'secretKey' => 'SECRET_KEY']);
$token = $nmpay->getToken();

```


```json
// Traitement ok
{
    "token_type":"Bearer",
    "expires_in":300,
    "access_token":"eyJ0eXAiOiJKV1QiLC.....62D6bMrXURW4udsk"
}

```

```json
// traitement avec erreur
null
```


```php 
// Vous pouvez utiliser votre token pour des appel curl. Avec la class Http par exemple 

 $response = Http::withHeaders([
    'Authorization' => 'Bearer ' . $token['access_token'],
    'Content-Type' => 'application/json',
    'User-Agent' => 'LE_USER_AGENT' //request()->header('User-Agent'),
    'X-Forwarded-For' =>'L_ADRESSE_IP' // request()->ip()
])->post($nmpay->apiUrl . '/v1/payins', $payload);

if ($response->successful()) {}

```

# Autre cas 
```php
// Configurer les clés API et l'URL de l'API une seule fois avec Config si vous souhaitez
$config = Config::getInstance();
$config->setKeys('PUBLIC_KEY', 'SECRET_KEY');
$config->setApiUrl('https://api.nextmux.com');

// Utilisation de la classe Pay
$pay = new Pay();
$response = $pay->with_mobile_money(
    'mtn', // operator_code
    [
        'fullname' => 'John Doe',
        'email' => 'john@example.com',
        'phone_number' => '237699999999',
        'amount' => 1000,
        'description' => 'Payment for services'
    ],
    [], // custom_params (optional)
    false // get_link (optional)
);

 
```
