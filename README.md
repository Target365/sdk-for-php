## ![Strex](https://github.com/Target365/sdk-for-php/raw/master/strex.png "Strex")
Strex AS is a Norwegian payment and SMS gateway (Strex Connect) provider. Strex withholds an e-money license and processes more than 70 million transactions every year. Strex has more than 4.2 mill customers in Norway and are owned by the Norwegian mobile network operators (Telenor, Telia and Ice). Strex Connect is based on the Target365 marketing and communication platform.

## Target365 SDK for PHP
[![License](https://img.shields.io/github/license/Target365/sdk-for-net.svg?style=flat)](https://opensource.org/licenses/MIT)

### Getting started
To get started, please click here: https://strex.no/strex-connect#Prispakker and register your organisation. 
For the SDK please send us an email at <sdk@strex.no> containing your RSA public key in PEM-format.
You can generate your RSA public/private key-pair using openssl like this:
```
openssl genpkey -algorithm RSA -pkeyopt rsa_keygen_bits:1024 -out private.pem
```
Use openssl to convert it to pk8 format which PHP uses.
```
openssl pkcs8 -topk8 -inform pem -in private.pem -outform pem -nocrypt -out private.key
```
The file `private.key` should look something like this:
```
-----BEGIN PRIVATE KEY-----
MIICdwIBADANBgkqhkiG9w0BAQEFAASCAmEwggJdAgEAAoGBAML6duyE7hL2XPEH
qiYtyghoj6pO21zGPwSaBKTCg6i3AeJ4Ob6pCnvYQA+rRfw/+aBfT+Rv3LTSmX2i
9bAsLQB0Q3y8zku2NmqE/yoqhb9GAhL3toMasBuJ3ifvUOXTajtGEKy++YkAkRBK
7Wi/bK/IQNZd9nsOtKxz5DXNELbHAgMBAAECgYAj6k8Nsk7IX2kvXOIStkyIz/nm
vS/bHwlsp5JDZzEpWsyWEt9QJ4Mu3N6wBDSYCpDI4cWtpo1ZIZH0epgXI4wGPv2j
a6ilWZywUdhFZw1AUc3qLRoapqIPliimLhxPWmV2OfvbA4LiNvWGsF/qTaqVQ/0V
ebj+JYjJdFQcTjqlwQJBAOpKQ/EyuzDlO7YVPmw0rAfVRfVqTIvzpZ3hGThztcnQ
igI3ftbGSOPUcter3/cX5ENrIGMP6hLsWqSKWECBwK0CQQDVC6mVkrit/VXby2Zp
8epgprGhrUHojNO7ojQQN1Mupr4AHUWr2Y3xJH1uXaOjafBc6uLK7Cri3eLru+iy
Ph/DAkBLG/fgEVV1fWfBHdpfMhucf0DoRmW30CpeDNXbBS1YP6SexU/CZtrjPy55
+b3ZJy2kd2lwmJ9/5YnBiiB0vaQZAkEAuTgPcrOBjfqu94zpd/hTTT3/NtGbeGNe
/UTywJpo3iknDJBmbxaQOfMAfcA5MSw8RXwMOmGCk4RW8Z2Hm9c44wJBAJvIcnMV
6b2G6pizPPjoPhV+eNruWTyFt5ralEmxDpqV3p4TP89KVvaBlkzlT28p1P9vp5bD
J6BLhdOAUfC3CMY=
-----END PRIVATE KEY-----
```
> Please note that when using the private key in PHP you must remove all newline characters so the whole private key is in one line.

Use this openssl command to extract the public key:
```
openssl rsa -in private.key -pubout -out public.key
```
You can then send us the `public.key` file. The file should look something like this:
```
-----BEGIN PUBLIC KEY-----
MIGfMA0GCSqGSIb3DQEBAQUAA4GNADCBiQKBgQDC+nbshO4S9lzxB6omLcoIaI+q
Tttcxj8EmgSkwoOotwHieDm+qQp72EAPq0X8P/mgX0/kb9y00pl9ovWwLC0AdEN8
vM5LtjZqhP8qKoW/RgIS97aDGrAbid4n71Dl02o7RhCsvvmJAJEQSu1ov2yvyEDW
XfZ7DrSsc+Q1zRC2xwIDAQAB
-----END PUBLIC KEY-----
```

For more details on using the SDK we strongly suggest you check out our [PHP User Guide](USERGUIDE.md).

### Composer
```
composer require target365/sdk
```
[![Latest Stable Version](https://poser.pugx.org/target365/sdk/v/stable)](https://packagist.org/packages/target365/sdk)

### Test Environment
Our test-environment acts as a sandbox that simulates the real API as closely as possible. This can be used to get familiar with the service before going to production. Please be ware that the simulation isn't perfect and must not be taken to have 100% fidelity.

#### Url: https://test.target365.io/

### Production Environment
Our production environment is a mix of per-tenant isolated environments and a shared common environment. Contact <sdk@strex.no> if you're interested in an isolated per-tenant environment.

#### Url: https://shared.target365.io/

### Authors and maintainers
Target365 (<sdk@strex.no>)

### Issues / Bugs / Questions
Please feel free to raise an issue against this repository if you have any questions or problems.

### Private Key
The Target365 PHP SDK only allows RSA private keys. The private key should be passed to the
`\Target365\ApiSdk\ApiClient` constructor. The key can optionally include `-----BEGIN RSA PRIVATE KEY-----`
parts. You must remove all newline characters from the private key when using the PHP SDK.

### Contributing
New contributors to this project are welcome. If you are interested in contributing please
send an email to sdk@strex.no.

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
