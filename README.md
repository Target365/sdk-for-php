## Target365.io API - PHP SDK

### Installation

```
composer require target-365/api-sdk
```

### Examples

Please see [example/example.php](example/example.php)

### Authors and maintainers

Sam Anthony <sam@expertcoder.io> (On behalf of Target365)

Hans Olav Stjernholm <support@target365.no>

### Datetime strings / timezone

To avoid confusion is is suggested that calls to the API should stick to UTC timezone (+00:00). Hence this
SDK has been developed to respect this suggestion.

### Issues / Bugs / Questions

Please feel free to raise an issue against this repository if you have any questions or problems

### Contributing

New contributors to this project are welcome. If you are interested in contributing please
send a courtesy email to support@target365.no and sam@expertcoder.io .

Please ensure you use the and update the automated test

#### Automated Testing

To run automated tests, please place a file in this folder called `private.key` which should contain a valid private key.
The test are currently hard coded to assume there is a test key called `RsaTestKey`. Contact Hans <support@target365.no>
regarding setting up test keys.

### License

This library is released under the MIT license.