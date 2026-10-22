## ![Strex](https://github.com/Target365/sdk-for-php/raw/master/strex.png "Strex")
Strex AS is a Norwegian payment and SMS gateway (Strex Connect) provider. Strex withholds an e-money license and processes more than 70 million transactions every year. Strex has more than 4.2 mill customers in Norway and are owned by the Norwegian mobile network operators (Telenor, Telia and Ice). Strex Connect is based on the Target365 marketing and communication platform.

## Target365 SDK for PHP
[![License](https://img.shields.io/github/license/Target365/sdk-for-net.svg?style=flat)](https://opensource.org/licenses/MIT)

### Getting started
To get started, please click here: https://strex.no/strex-connect#Prispakker and register your organisation. 

After registration you can activate the SDK by logging in to Strex Connect and create a key under "SDK keys" here:  
https://www.strexconnect.no/admin/public-key 

Click "Add new", and in the "SDK" tab select "PHP" as your SDK. Strex Connect generates the key pair and shows a
"Public key string" and a "Private key string". Copy the **"Private key string"**: that's the key the SDK needs (not the
"Public key string"). Store it safe and encrypted (we recommend AES-encryption). We only store the public key.
Set the expiry date, and optionally add an e-mail address so we can warn you when the key is about to expire.

The SDK signs requests with either an ECDSA P-256 key or an RSA key, depending on the private key you give it.

> The private key can be given as one line (as Strex Connect shows it), with or without the
> `-----BEGIN ...-----`/`-----END ...-----` lines, or as a PEM string with newlines.

Instead of letting Strex Connect generate the key pair, you can generate your own with openssl and add the public key in
the "From OpenSSL" tab, as described below.

#### ECDSA P-256 key
If you want, you can generate your own EC public/private key-pair using openssl like this and add it to the "From OpenSSL" tab:
```
openssl ecparam -name prime256v1 -genkey -noout -out private.pem
```
Use openssl to convert it to pk8 format:
```
openssl pkcs8 -topk8 -inform pem -in private.pem -outform pem -nocrypt -out private.key
```
Use this openssl command to extract the public key:
```
openssl ec -in private.pem -pubout -out public.key
```
Paste the middle part of `public.key` in the "Public key string" field and select "ECDsaP256" as "Sign algo" in the
"From OpenSSL" tab in Strex Connect. Use the middle part of `private.key` as the private key in the SDK.

> The PHP SDK supports ECDsaP256 and RSA keys. "ECDsaP521" (also listed in Strex Connect) is not supported.

#### RSA key
RSA keys created for earlier versions of the SDK keep working: the SDK signs with RSA when it is given an RSA private key.

For more details on using the SDK we strongly suggest you check out our [PHP User Guide](USERGUIDE.md).

### Composer
```
composer require target365/sdk
```
Requirements: PHP 8.2 or newer, the `openssl` and `json` extensions, and Guzzle 7 or 8.
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
The private key should be passed to the `\Target365\ApiSdk\ApiClient` constructor. The SDK supports:
* ECDSA P-256 (secp256r1) keys in PKCS#8 (`-----BEGIN PRIVATE KEY-----`) or SEC1 (`-----BEGIN EC PRIVATE KEY-----`) format
* RSA keys in PKCS#8 (`-----BEGIN PRIVATE KEY-----`) or PKCS#1 (`-----BEGIN RSA PRIVATE KEY-----`) format

The key can be one line (as Strex Connect shows it), with or without the `-----BEGIN ...-----` and `-----END ...-----` parts,
or a PEM string with newlines. The signing algorithm follows the key type, and must match the "Sign algo"
of the key in Strex Connect. Other EC curves than P-256 are not supported.

### Contributing
New contributors to this project are welcome. If you are interested in contributing please
send an email to Target365 (<support@target365.no>).

### Automated Test
Automated tests use PHPUnit framework. Here are some suggested steps to run
automated tests.

* Clone repository.
* Change to repository directory.
* (Optional) use vagrant file as `tests/Vagrantfile`
* Run `composer install`.
* Run the unit tests: `composer test`. They need no credentials.
* Run static analysis: `composer phpstan`.
* Integration tests call the Target365 test API:
  - Copy `tests/secrets.yml.dist` to `tests/secrets.yml` and fill in your test account's details.
    Enter `private_key` as a one line string without the `-----BEGIN ...-----` parts.
  - Run `composer test-integration`.

### License
This library is released under the MIT license.
