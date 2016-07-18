# economic-php-client

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