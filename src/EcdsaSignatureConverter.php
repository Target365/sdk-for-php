<?php

declare(strict_types = 1);

namespace Target365\ApiSdk;

use Target365\ApiSdk\Exception\ApiClientException;

/**
 * ECDSA signature conversion: openssl_sign() returns DER, the API expects raw r‖s (IEEE P1363).
 *
 * @internal
 */
final class EcdsaSignatureConverter
{
    /**
     * Converts a DER-encoded ECDSA signature, SEQUENCE { INTEGER r, INTEGER s }, as returned by openssl_sign(),
     * to raw r‖s with each part left-padded to $partLength bytes (IEEE P1363).
     *
     * @throws ApiClientException
     */
    public static function derToRaw(string $der, int $partLength): string
    {
        $offset = 0;

        if (self::readDerByte($der, $offset) !== 0x30) {
            throw new ApiClientException('Invalid ECDSA signature: expected a DER sequence');
        }

        $sequenceLength = self::readDerLength($der, $offset);

        if ($offset + $sequenceLength !== strlen($der)) {
            throw new ApiClientException('Invalid ECDSA signature: wrong DER sequence length');
        }

        $r = self::readDerInteger($der, $offset, $partLength);
        $s = self::readDerInteger($der, $offset, $partLength);

        if ($offset !== strlen($der)) {
            throw new ApiClientException('Invalid ECDSA signature: unexpected data after s');
        }

        return $r . $s;
    }

    /**
     * Reads an unsigned DER INTEGER and returns it left-padded to $partLength bytes.
     *
     * @throws ApiClientException
     */
    private static function readDerInteger(string $der, int &$offset, int $partLength): string
    {
        if (self::readDerByte($der, $offset) !== 0x02) {
            throw new ApiClientException('Invalid ECDSA signature: expected a DER integer');
        }

        $length = self::readDerLength($der, $offset);

        if ($length < 1 || $offset + $length > strlen($der)) {
            throw new ApiClientException('Invalid ECDSA signature: wrong DER integer length');
        }

        // DER adds a leading 0x00 when the high bit is set, so the integer isn't read as negative
        $value = ltrim(substr($der, $offset, $length), "\x00");
        $offset += $length;

        if (strlen($value) > $partLength) {
            throw new ApiClientException('Invalid ECDSA signature: integer too long for the curve');
        }

        return str_pad($value, $partLength, "\x00", STR_PAD_LEFT);
    }

    /**
     * Reads a DER length, in short form (< 128) or long form (0x81, 0x82 followed by the length bytes).
     *
     * @throws ApiClientException
     */
    private static function readDerLength(string $der, int &$offset): int
    {
        $length = self::readDerByte($der, $offset);

        if ($length < 0x80) {
            return $length;
        }

        $numberOfBytes = $length & 0x7f;

        if ($numberOfBytes < 1 || $numberOfBytes > 2) {
            throw new ApiClientException('Invalid ECDSA signature: unsupported DER length');
        }

        $length = 0;

        for ($i = 0; $i < $numberOfBytes; $i++) {
            $length = ($length << 8) | self::readDerByte($der, $offset);
        }

        return $length;
    }

    /**
     * @throws ApiClientException
     */
    private static function readDerByte(string $der, int &$offset): int
    {
        if (!isset($der[$offset])) {
            throw new ApiClientException('Invalid ECDSA signature: unexpected end of DER data');
        }

        return ord($der[$offset++]);
    }
}
