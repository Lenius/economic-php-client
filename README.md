E-conomic PHP REST CLIENT
===================
[![PHP Tests](https://github.com/Lenius/economic-php-client/actions/workflows/php.yml/badge.svg)](https://github.com/Lenius/economic-php-client/actions/workflows/php.yml) [![Code Coverage](https://scrutinizer-ci.com/g/Lenius/economic-php-client/badges/coverage.png?b=master)](https://scrutinizer-ci.com/g/Lenius/economic-php-client/?branch=master) [![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/Lenius/economic-php-client/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/Lenius/economic-php-client/?branch=master) [![Latest Stable Version](https://poser.pugx.org/Lenius/economic-php-client/v/stable)](https://packagist.org/packages/Lenius/economic-php-client) [![Total Downloads](https://poser.pugx.org/Lenius/economic-php-client/downloads)](https://packagist.org/packages/Lenius/economic-php-client) [![License](https://poser.pugx.org/Lenius/economic-php-client/license)](https://packagist.org/packages/Lenius/economic-php-client)

## Install

Via Composer

``` bash
$ composer require lenius/economic-php-client
```

## Documentation

Please see the [official e-conomic documentation](https://restdocs.e-conomic.com).

## Access all debitors
Call the Customers url /Customers
```php
$appToken = 'demo';
$grant    = 'demo';

$client = new Lenius\Economic\RestClient($appToken, $grant);

$parms = ['pagesize' => 100];

$response = $client->request->get('customers', $parms);

$status = $response->httpStatus();

if ($status == 200) {
    // Successful request
    $data = $response->asArray();
    print_r($data);
}
```

## Testing

Tests kræver PHP 8.2+ med Xdebug til code coverage. Den nemmeste måde er via Docker.

### Docker (anbefalet)

Byg image:
``` bash
docker build -t economic-php-test .
```

Kør alle checks (tests, PHPStan og Psalm):
``` bash
docker run --rm economic-php-test
```

Kør med code coverage HTML-rapport:
``` bash
docker run --rm -v "$(pwd)/build:/app/build" economic-php-test
```
Åbn `build/logs/phpunit-html/index.html` i en browser for at se rapporten.

Kør enkeltvis:
``` bash
docker run --rm economic-php-test composer test
docker run --rm economic-php-test composer stan
docker run --rm economic-php-test composer psalm
```

### Lokalt

Forudsætter PHP 8.2+, Composer og Xdebug installeret:

``` bash
composer test   # PHPUnit med code coverage
composer stan   # PHPStan statisk analyse
composer psalm  # Psalm statisk analyse
composer check  # Alle ovenstående på én gang
```

## Contributing

All PR's are welcome, just throw me one, and i take a look at it :)

## License

This code is release under the MIT License, which means you can do pretty much whatever you wanna do with it.
Take a look at the [LICENSE file](LICENSE) for more information.

## Author

This packages is originally developed and maintained by [Carsten Jonstrup](https://twitter.com/cjonstrup).
