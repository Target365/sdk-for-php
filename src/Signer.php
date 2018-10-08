<?php

declare(strict_types = 1);

namespace Target365\ApiSdk;

use phpseclib\Crypt\Hash;
use phpseclib\Crypt\RSA;

class Signer
{
    private $privateKey;

    /**
     * @param string $privateKey base64-encoded private key in pcks#8 format
     */
    public function __construct(
        string $privateKey
    )
    {
        if ( defined('CRYPT_RSA_PKCS15_COMPAT')) {
            if (CRYPT_RSA_PKCS15_COMPAT !== true) {
                throw new ApiClientException('Somehow the `CRYPT_RSA_PKCS15_COMPAT` constant has been set incorrectly');
            }
        } else {
            define('CRYPT_RSA_PKCS15_COMPAT', true);
        }

        $this->privateKey = $privateKey;
    }

    public function signRequest(
        string $requestMethod,
        string $requestUri,
        ?string $bodyContents,
        $epochTime,
        string $nonce
    ): string
    {
        $epochTime = (string) $epochTime;
        $requestMethod = strtolower($requestMethod);
        $requestUri = strtolower($requestUri);

        if ($bodyContents) {
            $bodyContentHash = $this->hashBodyContents($bodyContents);
        } else {
            $bodyContentHash = '';
        }

        $stringToSign = "{$requestMethod}{$requestUri}{$epochTime}{$nonce}{$bodyContentHash}";

        return $this->signString($stringToSign);
    }

    public function hashBodyContents(string $bodyContents): string
    {
        $hasher = new Hash();
        $hasher->setHash('sha256');
        $bodyContentsHash = $hasher->hash($bodyContents);

        return base64_encode($bodyContentsHash);
    }

    public function signString(string $stringToSign): string
    {
        $rsa = new RSA();
        $rsa->setHash('sha256');
        $rsa->loadKey($this->privateKey);
        $rsa->setEncryptionMode(RSA::ENCRYPTION_PKCS1);
        $rsa->setSignatureMode(RSA::SIGNATURE_PKCS1);

        return base64_encode($rsa->sign($stringToSign));
    }

    public function getAuthHeader(
        string $authKeyName,
        $epochTime,
        string $nonce,
        string $signedRequestString
    ): string
    {
        $epochTime = (string) $epochTime;

        return "HMAC {$authKeyName}:{$epochTime}:{$nonce}:{$signedRequestString}";
    }

}
