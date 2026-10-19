<?php

declare(strict_types = 1);

namespace Target365\ApiSdk\Tests\Unit;

use Target365\ApiSdk\EcdsaSignatureConverter;
use Target365\ApiSdk\Exception\ApiClientException;
use Target365\ApiSdk\Tests\AbstractTestCase;

class EcdsaSignatureConverterTest extends AbstractTestCase
{
    /**
     * @dataProvider ecdsaDerProvider
     */
    public function testDerToRaw(string $derHex, string $expectedRawHex): void
    {
        $raw = EcdsaSignatureConverter::derToRaw((string) hex2bin($derHex), 32);

        $this->assertSame($expectedRawHex, bin2hex($raw));
    }

    /**
     * @return array<string, array{string, string}>
     */
    public static function ecdsaDerProvider(): array
    {
        $r = str_repeat('11', 32);
        $s = str_repeat('22', 32);
        $highR = '80' . str_repeat('11', 31);
        $shortS = str_repeat('22', 30);

        return [
            'plain 32-byte r and s' => ['3044' . '0220' . $r . '0220' . $s, $r . $s],
            'r with high bit, DER adds 0x00' => ['3045' . '022100' . $highR . '0220' . $s, $highR . $s],
            'short s is left-padded' => ['3042' . '0220' . $r . '021e' . $shortS, $r . '0000' . $shortS],
        ];
    }

    /**
     * @dataProvider invalidEcdsaDerProvider
     */
    public function testDerToRawRejectsInvalidDer(string $derHex): void
    {
        $this->expectException(ApiClientException::class);

        EcdsaSignatureConverter::derToRaw((string) hex2bin($derHex), 32);
    }

    /**
     * @return array<string, array{string}>
     */
    public static function invalidEcdsaDerProvider(): array
    {
        $r = str_repeat('11', 32);
        $s = str_repeat('22', 32);

        return [
            'not a sequence' => ['3144' . '0220' . $r . '0220' . $s],
            'wrong sequence length' => ['3045' . '0220' . $r . '0220' . $s],
            'not an integer' => ['3044' . '0320' . $r . '0220' . $s],
            'integer too long' => ['3046' . '0222' . '1111' . $r . '0220' . $s],
            'truncated' => ['3044' . '0220' . $r . '0220' . substr($s, 0, 10)],
            'trailing data' => ['3046' . '0220' . $r . '0220' . $s . '0000'],
        ];
    }
}
