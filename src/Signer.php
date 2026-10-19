<?php

declare(strict_types = 1);

namespace Target365\ApiSdk;

use Target365\ApiSdk\Exception\ApiClientException;

class Signer
{
    /**
     * The API expects ECDSA P-256 (secp256r1) signatures as raw r‖s (IEEE P1363), each part 32 bytes
     */
    private const EC_CURVE_NAME = 'prime256v1';
    private const EC_SIGNATURE_PART_LENGTH = 32;

    private string $privateKey;

    /**
     * @param string $privateKey base64-encoded RSA or ECDSA P-256 private key in PKCS#8 format
     */
    public function __construct(
        string $privateKey
    ) {
        $this->privateKey = $privateKey;
    }

    /**
     * @param string      $requestMethod
     * @param string      $requestUri
     * @param string|null $bodyContents
     * @param int|string  $epochTime
     * @param string      $nonce
     * @return string
     * @throws ApiClientException
     */
    public function signRequest(
        string $requestMethod,
        string $requestUri,
        ?string $bodyContents,
        $epochTime,
        string $nonce
    ): string {
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
        return base64_encode(hash('sha256', $bodyContents, true));
    }

    /**
     * Signs with SHA-256: RSA PKCS#1 v1.5 for an RSA key, ECDSA for an EC P-256 key.
     *
     * @param string $stringToSign
     * @return string base64-encoded signature
     * @throws ApiClientException
     */
    public function signString(string $stringToSign): string
    {
        $key = $this->loadPrivateKey();
        $details = openssl_pkey_get_details($key);

        if ($details === false) {
            throw new ApiClientException('Failed to load key');
        }

        if ($details['type'] === OPENSSL_KEYTYPE_EC
            && ($details['ec']['curve_name'] ?? null) !== self::EC_CURVE_NAME
        ) {
            throw new ApiClientException('Unsupported EC key: only ECDSA P-256 (secp256r1) is supported');
        }

        if (!openssl_sign($stringToSign, $signed, $key, OPENSSL_ALGO_SHA256)) {
            throw new ApiClientException('Cant seem to sign string');
        }

        if ($details['type'] === OPENSSL_KEYTYPE_EC) {
            $signed = EcdsaSignatureConverter::derToRaw($signed, self::EC_SIGNATURE_PART_LENGTH);
        }

        return base64_encode($signed);
    }

    public function getAuthHeader(
        string $authKeyName,
        $epochTime,
        string $nonce,
        string $signedRequestString
    ): string {
        $epochTime = (string) $epochTime;

        return "HMAC {$authKeyName}:{$epochTime}:{$nonce}:{$signedRequestString}";
    }

    /**
     * Accepts the key as a single line, with or without the -----BEGIN ... PRIVATE KEY----- parts:
     * RSA in PKCS#8 ("PRIVATE KEY") or PKCS#1 ("RSA PRIVATE KEY") format,
     * EC in PKCS#8 ("PRIVATE KEY") or SEC1 ("EC PRIVATE KEY") format.
     *
     * @throws ApiClientException
     */
    private function loadPrivateKey(): \OpenSSLAsymmetricKey
    {
        $base64 = (string) preg_replace('/-----(BEGIN|END)[^-]*-----|\s+/', '', $this->privateKey);

        foreach (['PRIVATE KEY', 'RSA PRIVATE KEY', 'EC PRIVATE KEY'] as $type) {
            $pem = "-----BEGIN {$type}-----\n" . chunk_split($base64, 64, "\n") . "-----END {$type}-----\n";
            $key = openssl_pkey_get_private($pem);

            if ($key === false) {
                continue;
            }

            $details = openssl_pkey_get_details($key);

            if ($details !== false && in_array($details['type'], [OPENSSL_KEYTYPE_RSA, OPENSSL_KEYTYPE_EC], true)) {
                self::clearOpensslErrors();

                return $key;
            }
        }

        self::clearOpensslErrors();

        throw new ApiClientException('Failed to load key');
    }

    /**
     * The key format attempts above leave errors in OpenSSL's error queue, which would otherwise show up
     * in the application's own openssl_error_string() calls.
     */
    private static function clearOpensslErrors(): void
    {
        do {
            $error = openssl_error_string();
        } while ($error !== false);
    }
}
