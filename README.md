```bash
composer require nextmux/pay-sdk
```


```php
use Nextmux\PaySDK\Pay;
$pay = new Pay();
echo $pay->createPayment(100, 'USD');


use Nextmux\PaySDK\Config;
use Nextmux\PaySDK\Pay;

// Configurer les clés API et l'URL de l'API une seule fois
$config = Config::getInstance();
$config->setKeys('PUBLIC_KEY', 'SECRET_KEY');
$config->setApiUrl('https://api.nextmux.com');

// Utilisation de la classe Pay
$pay = new Pay();
$response = $pay->initiatePayment(100.00, 'USD', ['order_id' => '123']);

// Utilisation de la classe PayOut
$payout = new PayOut();
$response = $payout->createPayoutRequest(500.00, 'EUR', ['bank_account' => '987654']);

```