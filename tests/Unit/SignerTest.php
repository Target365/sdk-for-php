<?php

declare(strict_types = 1);

namespace Target365\ApiSdk\Tests\Unit;

use Target365\ApiSdk\Signer;
use Target365\ApiSdk\Tests\AbstractTestCase;

class SignerTest extends AbstractTestCase
{

    public function testGetAuthHeader()
    {
        $signer = new Signer($this->getPrivateKey());

        $authHeader = $signer->getAuthHeader(
            $this->authKeyName,
            1538052106,
            '85029f0d-a036-4c8d-88a7-9b0fbae5a279',
            'kJ8ZTlexM02qZUlNmc2pdNSYol8YMbYZr7SOWpLowo+J0904XGCuIyOy3UqeNIwRrocHUG14HYM5e0Zs1WtYbQ=='
        );

        $this->assertEquals(
            "HMAC {$this->authKeyName}:1538052106:85029f0d-a036-4c8d-88a7-9b0fbae5a279:kJ8ZTlexM02qZUlNmc2pdNSYol8YMbYZr7SOWpLowo+J0904XGCuIyOy3UqeNIwRrocHUG14HYM5e0Zs1WtYbQ==",
            $authHeader
        );
    }


    public function testSignString()
    {
        $signer = new Signer($this->getPrivateKey());

        $signedString = $signer->signString('TEST');


        $this->assertEquals(
            'LwwNtXwfNb9W064/RwApUWrM0kyB7aUIbh6W7UEZqeesIiN4Zsxg9uI1bVoxI6oZPy1+/5wbgANp/FbRo5HPDiGtghUU7XYUcN3Ya85l8SAReNrw9yhaN0Aoy0tTK3vPqbn331sepuDtr9gQubbJCOLpJ+DrR4pjZWH9azQbH2w=',
            $signedString
        );
    }

    public function testHashBodyContents()
    {
        $signer = new Signer($this->getPrivateKey());

        $signedString = $signer->hashBodyContents('TEST');

        $this->assertEquals(
            'lO4FkzXlh+UBzEv5BhPggU8Ap7CLx8ZI/YZaKvaiLMI=',
            $signedString
        );
    }
}

