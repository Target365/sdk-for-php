<?php

require_once ('../vendor/autoload.php');

// #### Initiate API Client ####
// Many elements of the SDK map one-to-one with API calls

$privateKey = \Target365\ApiSdk\PrivateKey::fromString('MIICXAIBAAKBgQCnaj.....56jQbOvhCzFuuTI=');

$apiClient = new \Target365\ApiSdk\ApiClient(
    'https://shared.target365.io/',
    'myAuthKeyName',
    $privateKey
);


// #### Keywords ####

// ## Get List

$apiClient->keywordResource()->getList();

// ## Post

$keyword = new \Target365\ApiSdk\Model\Keyword();
$keyword
    ->setKeywordText('abc');
//  ->setSomethingElse('abc')  call other setters

$apiClient->keywordResource()->post($keyword);

// ## Get One

$existingKeyword = $apiClient->keywordResource()->getOne();

// ## Put

$apiClient->keywordResource()->put($existingKeyword);

// ## Delete

$apiClient->keywordResource()->delete($existingKeyword->getIdentifier());

// #### Lookup ####

$lookupData = $apiClient->lookupResource()->getOne('+4798079008');

// #### OutMessages ####

// ## Prepare Msisdns

$apiClient->outMessageResource()->prepareMsisdns(['+4798079008']);

// ## Post

$outMessage1 = new \Target365\ApiSdk\Model\OutMessage();
$outMessage1
    ->setContent('Hi, this is the message :)');
//  ->setSomethingElse('abc')  call other setters


$apiClient->outMessageResource()->post($outMessage1);

// ## Post Batch

$outMessage1 = new \Target365\ApiSdk\Model\OutMessage();
$outMessage1
    ->setContent('Hi, this is the message :)');
//  ->setSomethingElse('abc')  call other setters

$outMessages = [
    $outMessage1,
];

$apiClient->outMessageResource()->postBatch($outMessages);

// #### Strex Merchants ####

// ## Put

$strexMerchant = new \Target365\ApiSdk\Model\StrexMerchant();

$strexMerchant
    ->setMerchantId($identifer);
//  ->setSomethingElse('abc')  call other setters

$apiClient->strexMerchantResource()->put($strexMerchant);

// ## Get List

$strexMerchants = $apiClient->strexMerchantResource()->getList();

// ## Get One

$strexMerchant = $apiClient->strexMerchantResource()->getOne($identifier);

// ## Delete

$apiClient->strexMerchantResource()->delete($strexMerchant->getIdentifier());
