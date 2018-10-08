<?php

declare(strict_types = 1);

namespace Target365\ApiSdk;

use phpseclib\Crypt\RSA;
use Psr\Http\Message\ResponseInterface;
use Psr\Log\LoggerInterface;
use Psr\Log\LogLevel;
use Target365\ApiSdk\Resource\lookupResource;
use Target365\ApiSdk\Resource\KeywordResource;
use Target365\ApiSdk\Resource\OutMessageResource;
use Target365\ApiSdk\Resource\StrexMerchantResource;

class ApiClient
{
    private $authKeyName;

    private $logger = null;

    private $resources;

    private $signer;

    /**
     * @param string $domainUri e.g. https://shared.target365.io/
     * @param string $authKeyName
     * @param PrivateKey $privateKey
     * @param LoggerInterface|null $logger
     */
    public function __construct(
        string $domainUri,
        string $authKeyName,
        PrivateKey $privateKey,
        LoggerInterface $logger = null
    )
    {
        // TODO update doc block for this method

        $this->authKeyName = $authKeyName;

        $this->logger = $logger;

        $this->instantiateResourceObjects();

        $this->signer = new Signer($privateKey);

        $this->baseUri = $this->tidyDomainUri($domainUri) . 'api/';

    }

    private function tidyDomainUri(string $domainUri)
    {
        // Add trailing slash if it is not present on the domain URI
        if (substr($domainUri, -1, 1) !== '/')
        {
            return $domainUri . '/';
        }

        return $domainUri;
    }

    protected function getSigner(): Signer
    {
        return $this->signer;
    }

    protected function getLogger(): ?LoggerInterface
    {
        return $this->logger;
    }

    private function instantiateResourceObjects()
    {
        foreach (
            [
                'lookup',
                'keyword',
                'outMessage',
                'strexMerchant',
            ] as $resource
        ) {
            $fqns = '\\Target365\\ApiSdk\\Resource\\' . ucfirst($resource) . 'Resource';
            $this->resources[$resource] = new $fqns($this);
        }
    }


    /*****************************
     * Start Resource Getters
     ****************************/
    public function lookupResource(): lookupResource
    {
        return $this->resources['lookup'];
    }

    public function keywordResource(): KeywordResource
    {
        return $this->resources['keyword'];
    }

    public function outMessageResource(): OutMessageResource
    {
        return $this->resources['outMessage'];
    }

    public function strexMerchantResource(): StrexMerchantResource
    {
        return $this->resources['strexMerchant'];
    }

    /*****************************
     * End Resource Getters
     ****************************/

    protected function log($logEntryTitle, $value, $logLevel = LogLevel::DEBUG)
    {
        if ($this->getLogger()) {
            $this->getLogger()->log($logLevel, "{$logEntryTitle}: {$value}");
        }
    }

    /**
     * @param string $requestMethod
     * @param string $requestUriPath the part of the URI which follows the domain name
     * @param array $bodyData associate array which will be Json encoded and added to request body
     *
     * @return ResponseInterface
     */
    public function request(
        string $requestMethod,
        string $requestUriPath,
        array $bodyData = null
    ): ResponseInterface
    {
        $requestUri = $this->baseUri . $requestUriPath;

        $signer = $this->getSigner();

        $nonce = (string) uniqid((string) time(), true);

        $this->log('requestUri', $requestUri);
        $this->log('requestMethod', $requestMethod);
        $this->log('nonce', $nonce);

        if ($bodyData) {
            $bodyContents = \GuzzleHttp\json_encode($bodyData);
        } else {
            $bodyContents = null;
        }

        $this->log('bodyContents', $bodyContents);

        $epochTime = time();

        $signedRequestString = $signer->signRequest(
            $requestMethod,
            $requestUri,
            $bodyContents,
            $epochTime,
            $nonce
        );

        $this->log('signedRequestString', $signedRequestString);

        $authHeader = $signer->getAuthHeader(
            $this->authKeyName,
            $epochTime,
            $nonce,
            $signedRequestString
        );

        $this->log('authHeader', $authHeader);

        $httpClient = $this->getHttpClient();

        $httpOptions['headers'] = [
                'Authorization' => $authHeader
        ];

        if ($bodyContents) {
            $httpOptions['body'] = $bodyContents;
        }

//        try {
            $response = $httpClient->request(
                $requestMethod,
                $requestUri,
                $httpOptions
            );
//        } catch (\GuzzleHttp\Exception\ClientException $e) {
//            $exceptionMessage = 'HTTP Request failed. Response Status Code: ' . $e->getResponse()->getStatusCode() . PHP_EOL .
//                                'Response Body: ' . $e->getResponse()->getBody()->__toString();
//
//            throw new ApiClientException($exceptionMessage, 0, $e);
//        }

        $this->log('Response Body', $response->getBody()->__toString());
        $this->log('Response Headers', \GuzzleHttp\json_encode($response->getHeaders()));

        return $response;
    }


    protected function getHttpClient(): \GuzzleHttp\Client
    {
        $options = [
        ];

        return new \GuzzleHttp\Client($options);
    }

}
