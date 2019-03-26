<?php

declare(strict_types = 1);

namespace Target365\ApiSdk\Tests\Unit;

use phpseclib\Crypt\RSA;
use Target365\ApiSdk\Signer;
use Target365\ApiSdk\Tests\AbstractTestCase;
use Target365\ApiSdk\Tests\Secrets;

class SignerTest extends AbstractTestCase
{
    /* @var Secrets  */
    protected $secrets;

    protected function setUp()
    {
        parent::setUp();
        $this->secrets = new Secrets();
    }


    /**
     * @throws \SebastianBergmann\RecursionContext\InvalidArgumentException
     * @throws \Target365\ApiSdk\Exception\ApiClientException
     */
    public function testGetAuthHeader(): void
    {
        $signer = new Signer($this->secrets->getPrivateKey());

        $authHeader = $signer->getAuthHeader(
            $this->secrets->getAuthKeyName(),
            1538052106,
            '85029f0d-a036-4c8d-88a7-9b0fbae5a279',
            'kJ8ZTlexM02qZUlNmc2pdNSYol8YMbYZr7SOWpLowo+J0904XGCuIyOy3UqeNIwRrocHUG14HYM5e0Zs1WtYbQ=='
        );

        $this->assertEquals(
            "HMAC {$this->secrets->getAuthKeyName()}:1538052106:85029f0d-a036-4c8d-88a7-9b0fbae5a279:kJ8ZTlexM02qZUlNmc2pdNSYol8YMbYZr7SOWpLowo+J0904XGCuIyOy3UqeNIwRrocHUG14HYM5e0Zs1WtYbQ==",
            $authHeader
        );
    }

    /**
     * @throws \SebastianBergmann\RecursionContext\InvalidArgumentException
     * @throws \Target365\ApiSdk\Exception\ApiClientException
     */
    public function testSignString(): void
    {
        $signer = new Signer($this->secrets->getPrivateKey());

        $signedString = $signer->signString('TEST');

        $rsa = new RSA();
        $rsa->setHash('sha256');
        $rsa->loadKey($this->secrets->getPublicKey());
        $rsa->setEncryptionMode(RSA::ENCRYPTION_PKCS1);
        $rsa->setSignatureMode(RSA::SIGNATURE_PKCS1);
        $verify = $rsa->verify('TEST', base64_decode($signedString));

        $this->assertTrue($verify);
    }

    /**
     * @throws \SebastianBergmann\RecursionContext\InvalidArgumentException
     * @throws \Target365\ApiSdk\Exception\ApiClientException
     */
    public function testHashBodyContents()
    {
        $signer = new Signer($this->secrets->getPrivateKey());

        $signedString = $signer->hashBodyContents('TEST');

        $this->assertEquals(
            'lO4FkzXlh+UBzEv5BhPggU8Ap7CLx8ZI/YZaKvaiLMI=',
            $signedString
        );
    }
}

