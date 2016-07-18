# economic-php-client

Economic-php-client
===================
[![Build Status](https://travis-ci.org/lenius/economic-php-client.svg)](https://travis-ci.org/lenius/economic-php-client) [![Code Coverage](https://scrutinizer-ci.com/g/lenius/economic-php-client/badges/coverage.png?b=master)](https://scrutinizer-ci.com/g/lenius/economic-php-client/?branch=master) [![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/lenius/economic-php-client/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/lenius/economic-php-client/?branch=master) [![Latest Stable Version](https://poser.pugx.org/lenius/economic-php-client/v/stable)](https://packagist.org/packages/lenius/economic-php-client) [![Total Downloads](https://poser.pugx.org/lenius/economic-php-client/downloads)](https://packagist.org/packages/lenius/economic-php-client) [![License](https://poser.pugx.org/lenius/economic-php-client/license)](https://packagist.org/packages/lenius/economic-php-client)


UNDER DEVELOPMENT - DONT USE


### Access all debitors
Call the Customers url /Customers
```php
$appToken = 'demo';
$grant = 'demo';

$client = new \Economic\RestClient($appToken,$grant);

$parms = ['pagesize'=>100];

$response = $client->request->get('customers',$parms);

$status = $response->httpStatus();

print_r($status);
if( $status == 200 ) {
    // Successful request
    $data = $response->asArray();
    print_r($data);
}
```