<?php

declare(strict_types = 1);

namespace Target365\ApiSdk;

class PrivateKey
{
    private $value;

    /**
     * @param string $value base64-encoded private key in pcks#8 format
     *                           (string may included  `-----BEGIN RSA PRIVATE KEY-----` but this is not required)
     */
    protected function __construct(string $value)
    {
        $this->value = $value;
    }

    public function getValue(): string
    {
        return $this->value;
    }

    static public function fromString(string $value): self
    {
        return new self($value);
    }

    static public function fromEnvironmentalVariable(string $environmentalVariableName = 'TARGET365_PRIVATE_KEY'): self
    {
        $value = getenv($environmentalVariableName);

        if (! $value) {
            throw new ApiClientException('Cannot find private key in specified environmental variable');
        }

        return new self($value);
    }

    static public function fromFile(string $fileName = 'private.key'): self
    {
        $value = file_get_contents($fileName);

        if (! $value) {
            throw new ApiClientException('Cannot find private key in specified file');
        }

        return new self($value);
    }

}