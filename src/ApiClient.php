<?php

declare(strict_types = 1);

namespace Target365\ApiSdk;

use Psr\Http\Message\ResponseInterface;
use Psr\Log\LoggerInterface;
use Psr\Log\LogLevel;
use Target365\ApiSdk\Resource\ClientPublicKeyResource;
use Target365\ApiSdk\Resource\InMessageResource;
use Target365\ApiSdk\Resource\LookupResource;
use Target365\ApiSdk\Resource\KeywordResource;
use Target365\ApiSdk\Resource\OneTimePasswordResource;
use Target365\ApiSdk\Resource\OutMessageResource;
use Target365\ApiSdk\Resource\ServerPublicKeyResource;
use Target365\ApiSdk\Resource\StrexMerchantResource;
use Target365\ApiSdk\Resource\StrexTransactionResource;
use Target365\ApiSdk\Resource\OneClickConfigResource;
use Target365\ApiSdk\Resource\StrexRegistrationResource;

class ApiClient
{
    private $authKeyName;

    private $logger = null;

    private $resources;

    private $signer;

    private $baseUri;

    /**
     * @param string               $domainUri e.g. https://shared.target365.io/
     * @param string               $authKeyName
     * @param string               $privateKey base64-encoded private key in pcks#8 format
     * @param LoggerInterface|null $logger
     * @throws Exception\ApiClientException
     */
    public function __construct(
        string $domainUri,
        string $authKeyName,
        string $privateKey,
        LoggerInterface $logger = null
    ) {
        $this->authKeyName = $authKeyName;

        $this->logger = $logger;

        $this->instantiateResourceObjects();

        $this->signer = new Signer($privateKey);

        $this->baseUri = $this->tidyDomainUri($domainUri) . 'api/';
    }

    private function tidyDomainUri(string $domainUri)
    {
        // Add trailing slash if it is not present on the domain URI
        if (substr($domainUri, -1, 1) !== '/') {
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
                'inMessage',
                'strexMerchant',
                'strexTransaction',
                'oneTimePassword',
                'clientPublicKey',
                'serverPublicKey',
                'oneClickConfig',
                'strexRegistration',
            ] as $resource
        ) {
            $fqns = '\\Target365\\ApiSdk\\Resource\\' . ucfirst($resource) . 'Resource';
            $this->resources[$resource] = new $fqns($this);
        }
    }

    public function lookupResource(): LookupResource
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

    public function inMessageResource(): InMessageResource
    {
        return $this->resources['inMessage'];
    }

    public function strexMerchantResource(): StrexMerchantResource
    {
        return $this->resources['strexMerchant'];
    }

    public function strexTransactionResource(): StrexTransactionResource
    {
        return $this->resources['strexTransaction'];
    }

    public function oneTimePasswordResource(): OneTimePasswordResource
    {
        return $this->resources['oneTimePassword'];
    }

    public function clientPublicKeyResource(): ClientPublicKeyResource
    {
        return $this->resources['clientPublicKey'];
    }

    public function serverPublicKeyResource(): ServerPublicKeyResource
    {
        return $this->resources['serverPublicKey'];
    }

    public function oneClickConfigResource(): OneClickConfigResource
    {
        return $this->resources['oneClickConfig'];
    }

    public function strexRegistrationResource(): StrexRegistrationResource
    {
        return $this->resources['strexRegistration'];
    }

    protected function log($logEntryTitle, $value, $logLevel = LogLevel::DEBUG)
    {
        if ($this->getLogger()) {
            $this->getLogger()->log($logLevel, "{$logEntryTitle}: {$value}");
        }
    }

    /**
     * @param string $requestMethod
     * @param string $requestUriPath the part of the URI which follows the domain name
     * @param array  $bodyData associate array which will be Json encoded and added to request body
     *
     * @return ResponseInterface
     * @throws Exception\ApiClientException
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \InvalidArgumentException
     */
    public function request(
        string $requestMethod,
        string $requestUriPath,
        array $bodyData = null
    ): ResponseInterface {
        $requestUri = $this->baseUri . $requestUriPath;

        $signer = $this->getSigner();

        $nonce = uniqid((string) time(), true);

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

        $httpOptions = [];

        $httpOptions['headers'] = [
                'Authorization' => $authHeader,
                'X-Sdk' => 'Php',
                'X-Sdk-Version' => '1.8.3'
        ];

        if ($bodyContents) {
            $httpOptions['body'] = $bodyContents;
        }

        $response = $httpClient->request(
            $requestMethod,
            $requestUri,
            $httpOptions
        );
        
        $this->log('Response Body', $response->getBody()->__toString());
        $this->log('Response Headers', \GuzzleHttp\json_encode($response->getHeaders()));

        return $response;
    }

    /**
     * @return \GuzzleHttp\Client
     * @throws \InvalidArgumentException
     */
    protected function getHttpClient(): \GuzzleHttp\Client
    {
        $options = [
        ];

        return new \GuzzleHttp\Client($options);
    }
}
