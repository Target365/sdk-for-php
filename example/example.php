<?php

require_once ('../vendor/autoload.php');

// #### Initiate API Client ####

$uri = 'https://shared.target365.io';
$keyName = '{Your-Key-Name}';
$privateKey = '{Your-Private-Key}';

$apiClient = new \Target365\ApiSdk\ApiClient(
    $uri,
    $keyName,
    $privateKey
);

// #### Keywords ####

// ## Get List

$apiClient->keywordResource()->list();

// ## Post

$keyword = new \Target365\ApiSdk\Model\Keyword();
$keyword
    ->setKeywordText('abc');

$keywordId = $apiClient->keywordResource()->post($keyword);

// ## Get One

$existingKeyword = $apiClient->keywordResource()->get($keywordId);

// ## Put

$apiClient->keywordResource()->put($existingKeyword);

// ## Delete

$apiClient->keywordResource()->delete($keywordId);

// #### Lookup ####

$lookupData = $apiClient->lookupResource()->get('+4798079008');

// #### OutMessages ####

// ## Prepare Msisdns

$apiClient->outMessageResource()->prepareMsisdns(['+4798079008']);

// ## Post

$outMessage1 = new \Target365\ApiSdk\Model\OutMessage();
$outMessage1
    ->setContent('Hi, this is the message :)');

$apiClient->outMessageResource()->post($outMessage1);

// ## Post Batch

$outMessage1 = new \Target365\ApiSdk\Model\OutMessage();
$outMessage1
    ->setContent('Hi, this is the message :)');

$outMessages = [
    $outMessage1,
];

$apiClient->outMessageResource()->postBatch($outMessages);

// #### Strex Merchants ####

// ## Put

$strexMerchant = new \Target365\ApiSdk\Model\StrexMerchant();

$strexMerchant
    ->setMerchantId('YourMerchantId')
    ->setShortNumberId('NO-0000')
    ->setPassword('YourPassword');

$apiClient->strexMerchantResource()->put($strexMerchant);

// ## Get List

$strexMerchants = $apiClient->strexMerchantResource()->list();

// ## Get One

$strexMerchant = $apiClient->strexMerchantResource()->get($strexMerchant->getIdentifier());

// ## Delete

$apiClient->strexMerchantResource()->delete($strexMerchant->getIdentifier());
