<?php

declare(strict_types = 1);

namespace Target365\ApiSdk\Tests\Unit;

use Target365\ApiSdk\Exception\ApiClientException;
use Target365\ApiSdk\Signer;
use Target365\ApiSdk\Tests\AbstractTestCase;

class SignerTest extends AbstractTestCase
{
    /**
     * Test-only RSA key (2048 bits, PKCS#8, one line). Not used anywhere else.
     */
    private const RSA_TEST_KEY = 'MIIEvQIBADANBgkqhkiG9w0BAQEFAASCBKcwggSjAgEAAoIBAQC1/e4gp+6r3PHXLROK/ifNNNSbtYxjb5rk9mwFL8+w7/Ld'
        . 'ppSyALd/rFIdy/xcnsOebvDlfjreOjAAW+7gO+nGvIsJ/s3+RCPXUYrSKOemZay0jEudpAlLibV8KvJb/tQaeA4RmV3L83ES'
        . '+upiUOjSr1rdseOmFJ3efn1g2uZtk7QX6ASqniUdrjN1at/ijYUFknh1qNwhfg+ZkgIDc7tSj/YEc8F/BwHjmVeAvDBMy84Z'
        . 'Aw2DMohMu+ORKuKpQXSJyxrKXtGHEm0cYrRI/lHX6kv142yA8PGfpCwbdkA9tTli9w2lfCLo3UnkS8l8CotCwl5ZMBQJ/Zso'
        . 'M3y9o1cHAgMBAAECggEAGt6e5dtldaJtYmOZWxAjODzwlvy6+YNkzyFC2ZExjOIgbXFGyvEoJoV+qj+Pxuz53M5sarW0Y1Mb'
        . '+zGXlyvBXEJCFPu11jChSg0T/etkKEEiupVsJJ4vcSOn0+lTVxnMnwvSp+6I1q/epfq92D4x4claFRlKjx7EIDF0uXQYSV0g'
        . '1G+9+WqHtmxr3Gg2/ZIuN52XZsfLJO7x2a1OBI3ypBtq3d0hPPCa+khuZ7MmwObVlNwvgBKMl8fE5/3+/LEVXILSRszFZiqy'
        . 'sGYH59BwaIexQd1g5CycYo18ZdyZ1C8QuGJ3zPOtqRxT022YIqYvPtDhGfkctboNLHJEvX/PgQKBgQD82qU8dlghgnbcpbZG'
        . 'IP+0/3DQNRJzQSVGaY/xls2cNK0t52j2LWufieemZiwpgEM/n4dKlPaoM54HZ1phighZrf77xs7T9abUM57Sjl2oV/vmRt6B'
        . 'pKlG6jI5BoVGgMwgztHmuvVYuJ1lBo7nW5cyY9f8+FQ1xRh9vw/QkoTgdwKBgQC4QZWwJoCdCG2RoVm1pcu6Yyj8RUPrBtAx'
        . 'aZnvx6mim45bf8fUDD2EI6GWbnGWuYxM+X1W310WidCWN37U3gfXFf+WB0qq1oYjQF9WF4lEnoNbYIfBOoihhhcSAEc7903t'
        . 'TyqLXPD5DL6L3t1HSu6xh2RMIxohZTSfFz4ZLaTx8QKBgQDIfaH5YCkfYPBYonj2AGJhJQ5RuVNI2gXxX/CH8jhUPJx4wn3C'
        . 'fV9R4CozEd7AhXhNMXQ4Gge+dTc/zZ6nqqhWW5XME+aZwLWomsm7ULFIs4MEI3t4tpSWq0ppVxdEQQoalYNv/RxfXftHSLz1'
        . 'C/XGOc7gQhObkw2JX37ttc/wnwKBgGziFNrrZcVmXZlZh/HX7/RM9MNfCyuv8wfAJ7+SdaQp2I4pjKS6NwAHLk3/JhCzxT0X'
        . 'kgHsLM5M0n5yfPi93FQ2I7s8w9sAunPKbowpjGyIX4d4G8EMHgGVg7yXfYDqO5qo1bNVUPFbnp55LLochcFTCOoVNDPX4qjA'
        . 'y2mFl5uBAoGABUDvY4YndmQN05tJLLGwZAPt0TSXUxof7Kuo7tQA1JTpEZ7NgepOiAEe/X1/3JeWDO3CZ3NR8dpauH54c7AK'
        . 'yWVzYRNAf/H6ZufVuRs6JBzLFuFXwdxtd5G9pTYT0pl2rPKH1gv1QW3DaHDVpkV2BB7P2PnGAjo+qvgHyUqvJqI=';

    /**
     * Signatures made with this key by target365/sdk v1.8.15 (phpseclib). RSA PKCS#1 v1.5 is deterministic,
     * so the output must stay byte-identical.
     */
    private const RSA_V1_8_15_SIGNATURE_TEST = 'YaIMOfw58sRGOPv1Y2Jvd5LrMdMxw/pV3ypMDiDFv4XpB6Xkl3IxNE1PnL1rLxmWHTkSoIbnDn4XQ+oKZnVe3INgB0wmAsQV'
        . 'OdtSjWVYOJUXrQ1EqkFjTZQHHoUzp6fG4TbNzKnq2at3C09RGU8LqtU8kbcktQU1ExGZ6g+WNIAHPQTU8rrUGWQvG65KVbk/'
        . 'NzI3gU4E6NRwMWqJZ0zSCoYWqVVbEmhPVyma5Zea0UsX8cl8hx5DBRp6dd+2flz4SNliNqqQIg9+6UpJRGNZGUEPKmoayMhz'
        . '8FQ1ljrOpkenQHHiwG6LKXcddb1r5K9dsexcmDWBRjauGOW02+bVyA==';
    private const RSA_V1_8_15_SIGNATURE_REQUEST = 'DoL/Z+24NHVbGriLL0MGfaFRDtJJ4mC+gSC/af7ueWYUwEaM0UjBHhyF2uXnjYhlgGVsvm0vRT0NNIvi7HI6Or3qAVv4BP8C'
        . 'a+LeRlwne0l1rNoiWU5aKNlqwO424Hns9ovvywpN/4VznfaKYa3JAOPCGDJOpziT9HoSfssk1e2pj/1zqZRfbpGkHJ3g4oo+'
        . 'exfhVmpQXOMsY5A4DbKxQQUO1HxvAzMGf4D34SjXdXwHVDr7Og+FY8i6awWyIXKfweVzA7d967U1stdZAuKjmAb2RIMAATyH'
        . 'uZr6wWVHSKW9igPnvv8NouUxPHB8bl0he/IQadYT9FKfC/YiasVZaQ==';

    /**
     * Test-only EC P-256 key in SEC1 format, as `openssl ecparam -name prime256v1 -genkey -noout` creates it.
     */
    private const EC_SEC1_TEST_KEY = 'MHcCAQEEIEa+RgWZhgut28d/bUAAE78OvFbuUsSwz4mzySJKiy7UoAoGCCqGSM49AwEHoUQDQgAE6Km4yZ8Ky/YUS/T9BIIaa6v31njI4PnQNKNRI/LvR6P2XvMdBuisIGtRX9h6KocF5hfDbCSaaFOeXvSiLISl4g==';
    private const EC_SEC1_TEST_PUBLIC_KEY = 'MFkwEwYHKoZIzj0CAQYIKoZIzj0DAQcDQgAE6Km4yZ8Ky/YUS/T9BIIaa6v31njI4PnQNKNRI/LvR6P2XvMdBuisIGtRX9h6KocF5hfDbCSaaFOeXvSiLISl4g==';

    public function testGetAuthHeader(): void
    {
        $signer = new Signer(self::RSA_TEST_KEY);

        $authHeader = $signer->getAuthHeader(
            'RsaTestKey',
            1538052106,
            '85029f0d-a036-4c8d-88a7-9b0fbae5a279',
            'kJ8ZTlexM02qZUlNmc2pdNSYol8YMbYZr7SOWpLowo+J0904XGCuIyOy3UqeNIwRrocHUG14HYM5e0Zs1WtYbQ=='
        );

        $this->assertSame(
            'HMAC RsaTestKey:1538052106:85029f0d-a036-4c8d-88a7-9b0fbae5a279:kJ8ZTlexM02qZUlNmc2pdNSYol8YMbYZr7SOWpLowo+J0904XGCuIyOy3UqeNIwRrocHUG14HYM5e0Zs1WtYbQ==',
            $authHeader
        );
    }

    public function testHashBodyContents(): void
    {
        $signer = new Signer(self::RSA_TEST_KEY);

        $this->assertSame('lO4FkzXlh+UBzEv5BhPggU8Ap7CLx8ZI/YZaKvaiLMI=', $signer->hashBodyContents('TEST'));
    }

    public function testRsaSignatureIsUnchangedFromV1815(): void
    {
        $signer = new Signer(self::RSA_TEST_KEY);

        $this->assertSame(self::RSA_V1_8_15_SIGNATURE_TEST, $signer->signString('TEST'));
        $this->assertSame(
            self::RSA_V1_8_15_SIGNATURE_REQUEST,
            $signer->signRequest(
                'POST',
                'https://test.target365.io/api/out-messages',
                '{"a":1}',
                1760000000,
                '5e0dbd8e-7f1c-4a7e-9a83-3c8a8a1c3f2b'
            )
        );
    }

    /**
     * @dataProvider rsaKeyFormatProvider
     */
    public function testRsaKeyFormats(string $privateKey, string $publicKeyPem): void
    {
        $signature = base64_decode((new Signer($privateKey))->signString('TEST'), true);

        $this->assertSame(1, openssl_verify('TEST', $signature, $publicKeyPem, OPENSSL_ALGO_SHA256));
    }

    /**
     * @return array<string, array{string, string}>
     */
    public static function rsaKeyFormatProvider(): array
    {
        $key = self::newKey(['private_key_bits' => 2048, 'private_key_type' => OPENSSL_KEYTYPE_RSA]);
        openssl_pkey_export($key, $pkcs8Pem);
        $publicKeyPem = openssl_pkey_get_details($key)['key'];
        $pkcs1Pem = self::pkcs8ToPkcs1Pem($pkcs8Pem);

        return [
            'PKCS#8, one line, no BEGIN/END' => [self::bare($pkcs8Pem), $publicKeyPem],
            'PKCS#8, one line with BEGIN/END' => [self::oneLine($pkcs8Pem), $publicKeyPem],
            'PKCS#8, PEM' => [$pkcs8Pem, $publicKeyPem],
            'PKCS#1, one line, no BEGIN/END' => [self::bare($pkcs1Pem), $publicKeyPem],
            'PKCS#1, one line with BEGIN/END' => [self::oneLine($pkcs1Pem), $publicKeyPem],
            'PKCS#1, PEM' => [$pkcs1Pem, $publicKeyPem],
        ];
    }

    /**
     * @dataProvider ecKeyFormatProvider
     */
    public function testEcdsaKeyFormats(string $privateKey, string $publicKeyPem): void
    {
        $signature = base64_decode((new Signer($privateKey))->signString('TEST'), true);

        $this->assertSame(64, strlen($signature), 'ECDSA P-256 signature must be raw r‖s, 64 bytes');
        $this->assertSame(
            1,
            openssl_verify('TEST', self::rawToDer($signature), $publicKeyPem, OPENSSL_ALGO_SHA256)
        );
    }

    /**
     * @return array<string, array{string, string}>
     */
    public static function ecKeyFormatProvider(): array
    {
        $key = self::newKey(['private_key_type' => OPENSSL_KEYTYPE_EC, 'curve_name' => 'prime256v1']);
        openssl_pkey_export($key, $pkcs8Pem);
        $publicKeyPem = openssl_pkey_get_details($key)['key'];

        $sec1Pem = "-----BEGIN EC PRIVATE KEY-----\n" . chunk_split(self::EC_SEC1_TEST_KEY, 64, "\n") . "-----END EC PRIVATE KEY-----\n";
        $sec1PublicKeyPem = "-----BEGIN PUBLIC KEY-----\n" . chunk_split(self::EC_SEC1_TEST_PUBLIC_KEY, 64, "\n") . "-----END PUBLIC KEY-----\n";

        return [
            'PKCS#8, one line, no BEGIN/END' => [self::bare($pkcs8Pem), $publicKeyPem],
            'PKCS#8, one line with BEGIN/END' => [self::oneLine($pkcs8Pem), $publicKeyPem],
            'PKCS#8, PEM' => [$pkcs8Pem, $publicKeyPem],
            'SEC1, one line, no BEGIN/END' => [self::EC_SEC1_TEST_KEY, $sec1PublicKeyPem],
            'SEC1, one line with BEGIN/END' => [self::oneLine($sec1Pem), $sec1PublicKeyPem],
            'SEC1, PEM' => [$sec1Pem, $sec1PublicKeyPem],
        ];
    }

    public function testEcdsaSignaturesAlwaysVerify(): void
    {
        // ECDSA is randomized; many signatures make r or s with leading zero bytes likely
        $key = self::newKey(['private_key_type' => OPENSSL_KEYTYPE_EC, 'curve_name' => 'prime256v1']);
        openssl_pkey_export($key, $pem);
        $publicKeyPem = openssl_pkey_get_details($key)['key'];
        $signer = new Signer(self::bare($pem));

        for ($i = 0; $i < 300; $i++) {
            $message = "message {$i}";
            $signature = base64_decode($signer->signString($message), true);

            $this->assertSame(64, strlen($signature));
            $this->assertSame(1, openssl_verify($message, self::rawToDer($signature), $publicKeyPem, OPENSSL_ALGO_SHA256));
        }
    }

    public function testEcdsaSignRequest(): void
    {
        $key = self::newKey(['private_key_type' => OPENSSL_KEYTYPE_EC, 'curve_name' => 'prime256v1']);
        openssl_pkey_export($key, $pem);
        $publicKeyPem = openssl_pkey_get_details($key)['key'];
        $signer = new Signer(self::bare($pem));

        $signature = $signer->signRequest('POST', 'https://test.target365.io/api/out-messages', '{"a":1}', 1760000000, 'n1');
        $expectedMessage = 'posthttps://test.target365.io/api/out-messages1760000000n1' . $signer->hashBodyContents('{"a":1}');

        $this->assertSame(
            1,
            openssl_verify($expectedMessage, self::rawToDer(base64_decode($signature, true)), $publicKeyPem, OPENSSL_ALGO_SHA256)
        );
    }

    public function testUnsupportedEcCurveIsRejected(): void
    {
        $key = self::newKey(['private_key_type' => OPENSSL_KEYTYPE_EC, 'curve_name' => 'secp384r1']);
        openssl_pkey_export($key, $pem);

        $this->expectException(ApiClientException::class);
        $this->expectExceptionMessage('only ECDSA P-256 (secp256r1) is supported');

        (new Signer(self::bare($pem)))->signString('TEST');
    }

    public function testLeavesNoOpensslErrorsBehind(): void
    {
        do {
            $error = openssl_error_string();
        } while ($error !== false);

        // PKCS#1 key: the PKCS#8 attempt fails first
        (new Signer(self::bare(self::pkcs8ToPkcs1Pem(self::rsaTestKeyPem()))))->signString('TEST');

        $this->assertFalse(openssl_error_string());
    }

    public function testInvalidKeyIsRejected(): void
    {
        $this->expectException(ApiClientException::class);
        $this->expectExceptionMessage('Failed to load key');

        (new Signer('not-a-key'))->signString('TEST');
    }

    /**
     * @param array<string, int|string> $options
     */
    private static function newKey(array $options): \OpenSSLAsymmetricKey
    {
        $key = openssl_pkey_new($options);

        if ($key === false) {
            throw new \RuntimeException('openssl_pkey_new() failed: ' . openssl_error_string());
        }

        return $key;
    }

    private static function rsaTestKeyPem(): string
    {
        return "-----BEGIN PRIVATE KEY-----\n" . chunk_split(self::RSA_TEST_KEY, 64, "\n") . "-----END PRIVATE KEY-----\n";
    }

    /**
     * Base64 body only, as Strex Connect shows the private key
     */
    private static function bare(string $pem): string
    {
        return (string) preg_replace('/-----(BEGIN|END)[^-]*-----|\s+/', '', $pem);
    }

    private static function oneLine(string $pem): string
    {
        return str_replace(["\r", "\n"], '', $pem);
    }

    /**
     * Converts raw r‖s back to a DER SEQUENCE { INTEGER r, INTEGER s } for openssl_verify()
     */
    private static function rawToDer(string $raw): string
    {
        $integers = '';

        foreach (str_split($raw, intdiv(strlen($raw), 2)) as $part) {
            $part = ltrim($part, "\x00");

            if ($part === '' || ord($part[0]) >= 0x80) {
                $part = "\x00" . $part;
            }

            $integers .= "\x02" . chr(strlen($part)) . $part;
        }

        return "\x30" . chr(strlen($integers)) . $integers;
    }

    private static function pkcs8ToPkcs1Pem(string $pkcs8Pem): string
    {
        $der = self::pkcs8PrivateKeyOctets($pkcs8Pem);

        return "-----BEGIN RSA PRIVATE KEY-----\n" . chunk_split(base64_encode($der), 64, "\n") . "-----END RSA PRIVATE KEY-----\n";
    }

    /**
     * The inner private key (PKCS#1 for RSA) from a PKCS#8 PrivateKeyInfo:
     * SEQUENCE { INTEGER version, SEQUENCE algorithm, OCTET STRING privateKey }
     */
    private static function pkcs8PrivateKeyOctets(string $pkcs8Pem): string
    {
        $der = (string) base64_decode(self::bare($pkcs8Pem), true);
        $offset = 0;

        self::readTagAndLength($der, $offset, 0x30); // PrivateKeyInfo
        $offset += self::readTagAndLength($der, $offset, 0x02); // version
        $offset += self::readTagAndLength($der, $offset, 0x30); // algorithm
        $length = self::readTagAndLength($der, $offset, 0x04); // privateKey

        return substr($der, $offset, $length);
    }

    private static function readTagAndLength(string $der, int &$offset, int $expectedTag): int
    {
        if (ord($der[$offset++]) !== $expectedTag) {
            throw new \UnexpectedValueException('Unexpected DER tag');
        }

        $length = ord($der[$offset++]);

        if ($length >= 0x80) {
            $numberOfBytes = $length & 0x7f;
            $length = 0;

            for ($i = 0; $i < $numberOfBytes; $i++) {
                $length = ($length << 8) | ord($der[$offset++]);
            }
        }

        return $length;
    }
}
