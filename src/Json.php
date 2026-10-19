<?php

declare(strict_types = 1);

namespace Target365\ApiSdk;

/**
 * Replaces \GuzzleHttp\json_encode()/json_decode() and GuzzleHttp\Utils::jsonEncode()/jsonDecode(),
 * which are deprecated in Guzzle 7 and removed in Guzzle 8. Same behaviour: throws on errors.
 *
 * @internal
 */
final class Json
{
    /**
     * @throws \InvalidArgumentException
     */
    public static function encode(mixed $value): string
    {
        $json = json_encode($value);

        if (json_last_error() !== JSON_ERROR_NONE) {
            throw new \InvalidArgumentException('json_encode error: ' . json_last_error_msg());
        }

        return $json;
    }

    /**
     * @throws \InvalidArgumentException
     */
    public static function decode(string $json, bool $assoc = false): mixed
    {
        $data = json_decode($json, $assoc);

        if (json_last_error() !== JSON_ERROR_NONE) {
            throw new \InvalidArgumentException('json_decode error: ' . json_last_error_msg());
        }

        return $data;
    }
}
