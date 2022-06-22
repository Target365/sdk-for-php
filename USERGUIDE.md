# PHP User Guide

## Table of Contents
* [Introduction](#introduction)
* [Setup](#setup)
    * [ApiClient](#apiclient)
* [Text messages](#text-messages)
    * [Send an SMS](#send-an-sms)
    * [Set DeliveryReport URL for an SMS](#set-deliveryreport-url-for-an-sms)
    * [Schedule an SMS for later sending](#schedule-an-sms-for-later-sending)
    * [Send a Payment SMS](#send-a-payment-sms)
    * [Edit a scheduled SMS](#edit-a-scheduled-sms)
    * [Delete a scheduled SMS](#delete-a-scheduled-sms)
    * [Send batch](#send-batch)
* [Payment transactions](#payment-transactions)
    * [Create a Strex payment transaction](#create-a-strex-payment-transaction)
    * [Create a Strex payment transaction with one-time password](#create-a-strex-payment-transaction-with-one-time-password)
    * [Reverse a Strex payment transaction](#reverse-a-strex-payment-transaction)
    * [Check status on Strex payment transaction](#check-status-on-strex-payment-transaction)
    * [Check Strex registration status](#check-strex-registration-status)
    * [Send Strex registration SMS](#send-strex-registration-sms)
* [One-click](#one-click)
    * [One-click config](#one-click-config)
    * [Recurring transaction](#recurring-transaction)
* [Lookup](#lookup)
    * [Address lookup for mobile number](#address-lookup-for-mobile-number)
* [Keywords](#keywords)
    * [Create a keyword](#create-a-keyword)
    * [Delete a keyword](#delete-a-keyword)
* [Forwards](#forwards)
    * [SMS forward](#sms-forward)
    * [DLR forward](#dlr-forward)
    * [DLR status codes](#dlr-status-codes)
* [Encoding and SMS length](#encoding-and-sms-length)
* [PreAuthorization](#preauthorization)

## Introduction
The Target365 SDK gives you direct access to our online services like sending and receiving SMS, address lookup and Strex payment transactions.
The SDK provides an appropriate abstraction level for PHP and is officially support by Target365.
The SDK also implements very high security (HMAC using RSA).

## Setup
### ApiClient
```PHP
use Target365\ApiSdk\ApiClient;

$baseUrl = "https://shared.target365.io";
$keyName = "YOUR_KEY";
$privateKey = "BASE64_RSA_PRIVATE_KEY";
$apiClient = new ApiClient($baseUrl, $keyName, $privateKey);
```
## Text messages

### Send an SMS
This example sends an SMS to 98079008 (+47 for Norway) from "Target365" with the text "Hello world from SMS!".
```PHP
$outMessage = new OutMessage();

$outMessage
    ->setTransactionId(uniqid((string) time(), true))
    ->setSender('Target365')
    ->setRecipient('+4798079008')
    ->setContent('Hello World from SMS!');

$apiClient->outMessageResource()->post($outMessage);
```
### Set DeliveryReport URL for an SMS
This example sends an SMS and later a [DeliveryReport](#dlr-forward) will be posted at the url specified below.
```PHP
$outMessage = new OutMessage();

$outMessage
    ->setTransactionId(uniqid((string) time(), true))
    ->setSender('Target365')
    ->setRecipient('+4798079008')
    ->setContent('Hello World from SMS!')
    ->setDeliveryReportUrl('https://your.site.com/sms/dlr');

$apiClient->outMessageResource()->post($outMessage);
```
### Schedule an SMS for later sending
This example sets up a scheduled SMS. Scheduled messages can be updated or deleted before the time of sending.
```PHP
$dateTime = new \DateTime();
$dateTime->add(\DateInterval::createFromDateString('1 hours'));
$sendTime = (new DateTimeAttribute($dateTime->format(\DateTime::ATOM)))->__toString();

$outMessage = new OutMessage();

$outMessage
    ->setTransactionId(uniqid((string) time(), true))
    ->setSender('Target365')
    ->setRecipient('+4798079008')
    ->setContent('Hello World from SMS!')
    ->setSendTime($sendTime);

$apiClient->outMessageResource()->post($outMessage);
```

### Send a Payment SMS
This example sends a donation payment SMS that costs 10 NOK.
```PHP
$strex = new StrexData();

$strex
    ->setInvoiceText('Thank you for your donation')
    ->setMerchantId('YOUR_MERCHANT_ID')
    ->setAge(18)
    ->setPrice(10)
    ->setTimeout(10)
    ->setServiceCode('14002');

$outMessage = new OutMessage();

$outMessage
    ->setTransactionId(uniqid((string) time(), true))
    ->setSender('Target365')
    ->setRecipient('+4798079008')
    ->setContent('This message costs 10 NOK.');
    ->setStrex($strex);

$apiClient->outMessageResource()->post($outMessage);
```

### Edit a scheduled SMS
This example updates a previously created scheduled SMS.
```PHP
$outMessage = $apiClient->outMessageResource()->get($transactionId);
$outMessage.content = $outMessage.content + " Extra text :)"

$apiClient->outMessageResource()->put($outMessage);
```

### Delete a scheduled SMS
This example deletes a previously created scheduled SMS.
```PHP
$apiClient->outMessageResource()->delete($transactionId);
```

### Send batch
This example sends a batch of messages in one operation.
Batches behave logically the same way as if you would send each message by itself and is offered only for performance reasons. Here are the limitations and restrictions when it comes to using batches:
* You can have up to 10 000 messages per batch operation.
* Each message in the batch must have a unique TransactionId, otherwise the operation will fail.
* If one or more messages have errors (like invalid recipient etc.) only those messages will fail, the rest will be processed normally.
* If you want a status per message you have to set the DeliveryReportUrl on each message.
```PHP
$outMessage1 = new OutMessage();

$outMessage1
    ->setTransactionId(str_replace('.', '-', uniqid((string) time(), true)))
    ->setSender('Target365')
    ->setRecipient('+4798079008')
    ->setContent('Hello!');

$outMessage2 = new OutMessage();

$outMessage2
    ->setTransactionId(str_replace('.', '-', uniqid((string) time(), true)))
    ->setSender('Target365')
    ->setRecipient('+4798079008')
    ->setContent('Hello again!');

$outMessages = [$outMessage1, $outMessage2];

$apiClient->outMessageResource()->postBatch($outMessages);
```

## Payment transactions
If your service requires a minimum age of the End User, each payment transaction should be defined with minimum age. Both StrexTransaction and OutMessage have a property named “Age”. If not set or present in the request, there is no age limit.

### Create a Strex payment transaction
This example creates a 1 NOK Strex payment transaction that the end user will confirm by replying "OK" to an SMS from Strex.
You can use message_prefix and message_suffix custom properties to influence the start and end of the SMS sent by Strex.
```PHP
$properties = new Properties();
$properties->message_prefix = "Dear customer...";
$properties->message_suffix = "Best regards...";

$transaction = new StrexTransaction();

$transaction
    ->setTransactionId(uniqid((string) time(), true))
    ->setShortNumber('2002')
    ->setRecipient('+4798079008')
    ->setMerchantId('YOUR_MERCHANT_ID')
    ->setPrice(1)
    ->setServiceCode('14002')
    ->setInvoiceText('Donation test')
    ->setSmsConfirmation(true)
    ->setProperties($properties);

$apiClient->strexTransactionResource()->post($transaction);
```

### Create a Strex payment transaction with one-time password
This example creates a Strex one-time password sent to the end user and get completes the payment by using the one-time password.
You can use MessagePrefix and MessageSuffix to influence the start and end of the SMS sent by Strex.
```PHP
$transactionId = uniqid((string) time(), true);

$oneTimePassword = new OneTimePassword();

$oneTimePassword
    ->setTransactionId($transactionId)
    ->setSender('Target365')
    ->setRecipient('+4798079008')
    ->setMerchantId('YOUR_MERCHANT_ID')
    ->setMessagePrefix('Dear customer...')
    ->setMessageSuffix('Best regards...')
    ->setRecurring(false);
    
$apiClient->oneTimePasswordResource()->post($oneTimePassword);

/* Get input from end user (eg. via web site) */

$transaction = new StrexTransaction();

$transaction
    ->setTransactionId(uniqid((string) time(), true))
    ->setShortNumber('2002')
    ->setRecipient('+4798079008')
    ->setMerchantId('YOUR_MERCHANT_ID')
    ->setPrice(1)
    ->setServiceCode('14002')
    ->setInvoiceText('Donation test')
    ->setOneTimePassword('ONE_TIME_PASSWORD_FROM_USER');

$apiClient->strexTransactionResource()->post($transaction);
```

### Reverse a Strex payment transaction
This example reverses a previously billed Strex payment transaction. The original transaction will not change, but a reversal transaction will be created that counters the previous transaction by a negative Price. The reversal is an asynchronous operation that usually takes a few seconds to finish.
```PHP
$reversalTransactionId = $apiClient->strexTransactionResource()->reverse($transactionId);
```

### Check status on Strex payment transaction
This example gets a previously created Strex transaction to check its status. This method will block up to 20 seconds if the transaction is still being processed.
```PHP
$transaction = $apiClient.strexTransactionResource()->get($transactionId);
$statusCode = transaction->getStatusCode();
```

### Check Strex registration status
This example checks to the the Strex registration level for an end user. User validity is either Unregistered, Partial, Full or Barred. Some service codes and high amounts requires full registration.
```PHP
$validity = $apiClient->strexRegistrationResource()->getUserValidity('YOUR_MERCHANT_ID', '+4798079008');
```

### Send Strex registration SMS
This example sends a Strex registration SMS to an end user. Strex end user registration is required for some service codes and high amounts.
```PHP
$registrationSms = new StrexRegistrationSms();

$registrationSms
	->setMerchantId('YOUR_MERCHANT_ID')
	->setTransactionId('YOUR_TRANSACTION_ID')
	->setRecipient('+4798079008')
	->setSmsText('Please register.');

$apiClient->strexRegistrationResource()->post($registrationSms);
```

## One-click

Please note:

* The OneClick service will not stop same MSISDN to order several times as long as transactionID is unique. If end users order or subscribe several times to same service it's the merchants responsibility to refund the end user.

* Recurring billing is initiated by merchants, see section [Payment transactions](#payment-transactions) for more info.

* Since the one-click flow ends by redirecting the end user to an external merchant-controlled URL we recommend that merchants implement a mechanism to check status on all started transactions. If there’s any issue for the end user on their way to the last page they might have finished the payment, but not been able to get their product.

### One-click config
This example sets up a one-click config which makes it easier to handle campaigns in one-click where most properties like merchantId, price et cetera are known in advance. You can redirect the end-user to the one-click campaign page by redirecting to http://betal.strex.no/{YOUR-CONFIG-ID} for PROD and http://test-strex.target365.io/{YOUR-CONFIG-ID} for TEST-environment. You can also set the TransactionId by adding ?id={YOUR-TRANSACTION-ID} to the URL.

```PHP
$config = new OneClickConfig();

$config
    ->setConfigId('YOUR_CONFIG_ID')
    ->setShortNumber('2002')
    ->setPrice(99)
    ->setMerchantId('YOUR_MERCHANT_ID')
    ->setServiceCode('14002')
    ->setInvoiceText('Donation test')
    ->setOnlineText('Buy directly')
    ->setOfflineText('Buy with PIN-code')
    ->setRedirectUrl('https://your-return-url.com?id={TransactionId}') // {TransactionId} is replaced by actual transaction id
    ->setSubscriptionPrice(99)
    ->setSubscriptionInterval('monthly')
    ->setSubscriptionStartSms('Thanks for donating 99kr each month.')
    ->setRecurring(true)
    ->setIsRestricted(false)
    ->setAge(18);

$apiClient->oneClickConfigResource()->put($config);
```

If Recurring is set to 'false', the following parameters are optional:

* SubscriptionInterval - Possible values are "weekly", "monthly", "yearly"

* SubscriptionPrice - How much the subscriber will be charged each interval

This parameter is optional:

* SubscriptionStartSms - SMS that will be sent to the user when subscription starts.

### Recurring transaction
This example sets up a recurring transaction for one-click. After creation you can immediately get the transaction to get the status code - the server will wait up to 20 seconds for the async transaction to complete.
![Recurring sequence](https://github.com/Target365/sdk-for-php/raw/master/oneclick-recurring-flow.png "Recurring sequence diagram")
```PHP
$transactionId = uniqid((string) time(), true);

$transaction
    ->setTransactionId($transactionId)
    ->setRecipient("RECIPIENT_FROM_SUBSCRIPTION_TRANSACTION")
    ->setShortNumber('2002')
    ->setMerchantId('YOUR_MERCHANT_ID')
    ->setPrice(1)
    ->setServiceCode('14002')
    ->setInvoiceText('Donation test')
    ->setProperties($properties);

$apiClient->strexTransactionResource()->post($transaction);
$transaction = $apiClient->strexTransactionResource()->get($transactionId);

// TODO: Check transaction.StatusCode
```

## Lookup

### Address lookup for mobile number
This example looks up address information for the mobile number 98079008. Lookup information includes registered name and address.
```PHP
$lookup = $apiClient->lookupResource()->get('+4798079008');
$firstName = $lookup.firstName;
$lastName = $lookup.lastName;
```

## Keywords

### Create a keyword
This example creates a new keyword on short number 2002 that forwards incoming SMS messages to 2002 that starts with "HELLO" to the URL  "https://your-site.net/api/receive-sms".
```PHP
$keyword = new Keyword();

$keyword
    ->setShortNumberId('NO-2002')
    ->setKeywordText('HELLO')
    ->setMode('Text')
    ->setForwardUrl('https://your-site.net/api/receive-sms')
    ->setEnabled(true);
    
$keywordId = $apiClient->keywordResource()->post($keyword);
```

### Delete a keyword
This example deletes a keyword.
```PHP
$apiClient->keywordResource()->delete($keywordId);
```
## Forwards

### SMS forward
This example shows how SMS messages are forwarded to the keywords ForwardUrl. All sms forwards expects a response with status code 200 (OK). If the request times out or response status code differs the forward will be retried several times.
#### Request
```
POST https://your-site.net/api/receive-sms HTTP/1.1
Content-Type: application/json
Host: your-site.net

{
  "transactionId":"00568c6b-7baf-4869-b083-d22afc163059",
  "created":"2019-02-07T21:11:00+00:00",
  "sender":"+4798079008",
  "recipient":"2002",
  "content":"HELLO"
}
```

#### Response
```
HTTP/1.1 200 OK
Date: Thu, 07 Feb 2019 21:13:51 GMT
Content-Length: 0
```

### DLR forward
This example shows how delivery reports (DLR) are forwarded to the outmessage DeliveryReportUrl. All DLR forwards expect a response with status code 200 (OK). If the request times out or response status code differs the forward will be retried 10 times with exponentially longer intervals for about 15 hours.
#### Request
```
POST https://your-site.net/api/receive-dlr HTTP/1.1
Content-Type: application/json
Host: your-site.net

{
    "correlationId": null,
    "transactionId": "client-specified-id-5c88e736bb4b8",
    "price": null,
    "sender": "Target365",
    "recipient": "+4798079008",
    "operatorId": "no.telenor",
    "statusCode": "Ok",
    "detailedStatusCode": "Delivered",
    "delivered": true,
    "billed": null,
    "smscTransactionId": "16976c7448d",
    "smscMessageParts": 1
}
```

#### Response
```
HTTP/1.1 200 OK
Date: Thu, 07 Feb 2019 21:13:51 GMT
Content-Length: 0
```

Several methods exists for instantiating a DeliveryReport object from the received JSON:
 
```PHP
try
{
    // If the post request is received in the form of a PSR-7 Request:
    $dlr = DeliveryReport::fromPsrRequest($request);
    
    // Using php://input
    $dlr = DeliveryReport::fromRawPostData($request);
     
    // Or by simply passing in the received json string:
    $dlr = DeliveryReport::fromJsonString($request);
} 
catch (\InvalidArgumentException $e)
{
}
```

### DLR status codes
Delivery reports contains two status codes, one overall called `StatusCode` and one detailed called `DetailedStatusCode`.

#### StatusCode values
|Value|Description|
|:---|:---|
|Queued|Message is queued|
|Sent|Message has been sent|
|Failed|Message has failed|
|Ok|message has been delivered/billed|
|Reversed|Message billing has been reversed|

#### DetailedStatusCode values
|Value|Description|
|:---|:---|
|None|Message has no status|
|Delivered|Message is delivered to destination|
|Expired|Message validity period has expired|
|Undelivered|Message is undeliverable|
|MissingDeliveryReport|No DLR recieved from operator during the TimeToLive of the message|
|UnknownError|Obsolete. Replaced by OtherError|
|Rejected|Message has been rejected|
|UnknownSubscriber|Unknown subscriber|
|SubscriberUnavailable|Subscriber unavailable|
|SubscriberBarred|Subscriber barred|
|InsufficientFunds|Insufficient funds|
|RegistrationRequired|Registration required|
|UnknownAge|Unknown age|
|DuplicateTransaction|Duplicate transaction|
|SubscriberLimitExceeded|Subscriber limit exceeded|
|MaxPinRetry|Max pin retry reached|
|InvalidAmount|Invalid amount|
|OneTimePasswordExpired|One-time password expired|
|OneTimePasswordFailed|One-time password failed|
|SubscriberTooYoung|Subscriber too young|
|TimeoutError|Timeout error|
|Stopped|Message is part of more than 100 identical messages in an hour and stopped, assuming it is part of an eternal loop|
|OtherError|Miscellaneous. Errors not covered by statuses above|

## Encoding and SMS length
When sending SMS messages, we'll automatically send messages in the most compact encoding possible. If you include any non GSM-7 characters in your message body, we will automatically fall back to UCS-2 encoding (which will limit message bodies to 70 characters each).

Additionally, for long messages--greater than 160 GSM-7 characters or 70 UCS-2 characters--we will split the message into multiple segments. Six (6) bytes is also needed to instruct receiving device how to re-assemble messages, which for multi-segment messages, leaves 153 GSM-7 characters or 67 UCS-2 characters per segment.

Note that this may cause more message segments to be sent than you expect - a body with 152 GSM-7-compatible characters and a single unicode character will be split into three (3) messages because the unicode character changes the encoding into less-compact UCS-2. This will incur charges for three outgoing messages against your account.

Norwegian operators support different numbers of segments; Ice 12 segments, Telia 20 segments and Telenor 255 segments.

## PreAuthorization

Some servicecodes require recurring billing to be authorized by the user via an confirmation sms. This authorization can be activated on the keyword by either activating it in the
Preauth section of the keyword in Strex Connect or adding some settings to the keyword object when creating it via the API:

```
{
  "preAuthSettings": {
    "active": true,
    "InfoText": "Info message sent before preauth message",
    "InfoSender": "Sender of info message",
    "PrefixMessage": "Text inserted before preauth text",
    "PostfixMessage": "ext inserted after preauth text",
    "Delay": "Delay in minutes between info message and preauth message",
    "MerchantId": MerchantId to perform preauth on"",
    "ServiceDescription": "Service description for Strex 'Min Side'",
  }
}
```

In-messages forwarded to you will then look like this:
```
POST https://your-site.net/api/receive-sms HTTP/1.1
Content-Type: application/json

{
  "transactionId":"00568c6b-7baf-4869-b083-d22afc163059",
  "created": "2021-12-06T09:50:00+00:00",
  "keywordId": "12345678",
  "sender":"+4798079008",
  "recipient":"2002",
  "content": "HELLO",
  "properties": {
    "ServiceId": "1234",
    "preAuthorization": true
  }
}
```
If PreAuthorization was not successfully performed, "preAuthorization" will be "false".

The new properties are ServiceId and preAuthorization. ServiceId must be added to the outmessage/transaction when doing rebilling, as "preAuthServiceId". 
The ServiceId is identical for all incoming messages to the same keyword. Incoming messages forwarded with "preAuthorization" set as "false" are not possible
to bill via Strex Payment.

### MT rebilling with preAuth:
```PHP
$strex = new StrexData();
$strex
    ->setMerchantId('your-merchant-id')
    ->setAge(18)
    ->setPrice(10)
    ->setServiceCode('your-service-code')
    ->setInvoiceText('your-invoice-text')
    ->setPreAuthServiceId('1234')
    ->setPreAuthServiceDescription('your-subscription-description');

$outMessage = new OutMessage();

$outMessage
    ->setTransactionId('your-unique-id')
    ->setSender('2002')
    ->setRecipient('+4798079008')
    ->setContent('your-sms-text-to-end-user')
    ->setStrex($strex);

$apiClient->outMessageResource()->post($outMessage);
```
### Silent rebilling with preauth:
```PHP
$strex = new StrexData();
$strex
    ->setMerchantId('your-merchant-id')
    ->setPrice(0)
    ->setServiceCode('your-service-code')
    ->setInvoiceText('your-invoice-text')
    ->setPreAuthServiceId('1234')
    ->setPreAuthServiceDescription('your-subscription-description');

$properties = new Properties();
$properties->SilentPreAuthorization = true;

$outMessage = new OutMessage();

$outMessage
    ->setTransactionId('your-unique-id')
    ->setSender('2002')
    ->setRecipient('+4798079008')
    ->setStrex($strex)
    ->setProperties($properties);

$apiClient->outMessageResource()->post($outMessage);
```
Note that content is not set. If setting it, it must be set to null.

preAuthServiceId: Id chosen by you, store it so you can use it for rebilling.
preAuthServiceDescription: Optional, this text will be visible for the user on "My Page" in the Strex web page.

PreAuth of new users can be done in the same way, but without "SilentPreAuthorization" set. The user will then receive an SMS he must reply OK to.

If you want that the user should get a pin code, this must be done in 2 steps. First step is to trigger sending of the pin code and second step is to confirm the pin code the user has input on you web page.

Examples:
```PHP
$transactionId = 'your-unique-id';

// Before setting pin from end-user

$oneTimePassword = new OneTimePassword();

$oneTimePassword
    ->setTransactionId($transactionId)
    ->setMerchantId('your-merchant-id')
    ->setSender('2002')
    ->setRecipient('+4798079008')
    ->setRecurring(true);
    
$apiClient->oneTimePasswordResource()->post($oneTimePassword);

// After getting pin from end-user

$strex = new StrexData();
$strex
    ->setMerchantId('your-merchant-id')
    ->setAge(18)
    ->setPrice(10)
    ->setServiceCode('your-service-code')
    ->setInvoiceText('your-invoice-text')
    ->setPreAuthServiceId('1234')
    ->setPreAuthServiceDescription('your-subscription-description')
    ->setOneTimePassword('pin-from-enduser');

$outMessage = new OutMessage();

$outMessage
    ->setTransactionId($transactionId)
    ->setSender('2002')
    ->setRecipient('+4798079008')
    ->setStrex($strex);

$apiClient->outMessageResource()->post($outMessage);
```
