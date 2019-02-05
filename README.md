## Target365 SDK for PHP
[![License](https://img.shields.io/github/license/Target365/sdk-for-net.svg?style=flat)](https://opensource.org/licenses/MIT)

### Getting started
To get started please send us an email at <support@target365.no> containing your EC public key in DER(ANS.1) format.
If you want, you can generate your RSA public/private key-pair here: <http://travistidwell.com/jsencrypt/demo/>

### Composer
```
composer require target365/sdk
```
[![Latest Stable Version](https://poser.pugx.org/target365/sdk/v/stable)](https://packagist.org/packages/target365/sdk)

### Examples
Please see [example/example.php](example/example.php)

### Authors and maintainers
Target365 (<support@target365.no>)

### Issues / Bugs / Questions
Please feel free to raise an issue against this repository if you have any questions or problems.

### Private Key
The Target365 PHP SDK only allows RSA private keys. The private key should be passed to the
`\Target365\ApiSdk\ApiClient` constructor. The key can optionally include `-----BEGIN RSA PRIVATE KEY-----`
parts.

### Contributing
New contributors to this project are welcome. If you are interested in contributing please
send an email to support@target365.no.

### Automated Test
Automated tests use PHPUnit framework. Here are some suggested steps to run
automated tests.

* Clone repository.
* Change to repository directory.
* (Optional) use vagrant file as `tests/Vagrantfile`
* Run `composer install`.
  - Running composer will prompt you to enter some required details which will
be stored in a file called `tests/secrets.yml`.
  - When entering `private_key` enter the key as a one line string and exclude
the `-----BEGIN RSA PRIVATE KEY-----` parts.
* Run PHPUnit. `./vendor/bin/phpunit`

### License
This library is released under the MIT license.
