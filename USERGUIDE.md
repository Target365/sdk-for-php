# PHP User Guide

## Table of Contents
* [Introduction](#introduction)
* [Setup](#setup)
    * [ApiClient](#apiclient)
* [Text messages](#text-messages)
    * [Send an SMS](#send-an-sms)
    * [Schedule an SMS for later sending](#schedule-an-sms-for-later-sending)
    * [Edit a scheduled SMS](#edit-a-scheduled-sms)
    * [Delete a scheduled SMS](#delete-a-scheduled-sms)
* [Payment transactions](#payment-transactions)
    * [Create a Strex payment transaction](#create-a-strex-payment-transaction)
    * [Create a Strex payment transaction with one-time password](#create-a-strex-payment-transaction-with-one-time-password)
    * [Reverse a Strex payment transaction](#reverse-a-strex-payment-transaction)
* [Lookup](#lookup)
    * [Address lookup for mobile number](#address-lookup-for-mobile-number)
* [Keywords](#keywords)
    * [Create a keyword](#create-a-keyword)
    * [Delete a keyword](#delete-a-keyword)
* [Forwards](#forwards)
    * [SMS forward](#sms-forward)
    * [DLR forward](#dlr-forward)

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

## Payment transactions

### Create a Strex payment transaction
This example creates a 1 NOK Strex payment transaction that the end user will confirm by replying "OK" to an SMS from Strex.
```PHP
$transaction = new StrexTransaction();

$transaction
    ->setTransactionId(uniqid((string) time(), true))
    ->setShortNumber('2002')
    ->setRecipient('+4798079008')
    ->setMerchantId('YOUR_MERCHANT_ID')
    ->setPrice(1)
    ->setServiceCode('14002')
    ->setInvoiceText('Donation test');

$apiClient->strexTransactionResource()->post($transaction);
```

### Create a Strex payment transaction with one-time password
This example creates a Strex one-time password sent to the end user and get completes the payment by using the one-time password.
```PHP
$transactionId = uniqid((string) time(), true);

$oneTimePassword = new OneTimePassword();

$oneTimePassword
    ->setTransactionId($transactionId)
    ->setSender('Target365')
    ->setRecipient('+4798079008')
    ->setMerchantId('YOUR_MERCHANT_ID')
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
$reversalTransactionId = $apiClient->strexTransactionResource()->reverse($transaction);
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
