<?php

declare(strict_types = 1);

namespace Target365\ApiSdk\Tests;

use Symfony\Component\Yaml\Yaml;

class Secrets
{
    private $parameters;

    public function __construct()
    {
        $data = Yaml::parseFile(__DIR__ . '/secrets.yml');

        $this->parameters = $data['parameters'];
    }

    public function getDomainUri(): string
    {
        return $this->parameters['domain_uri'];
    }

    public function getAuthKeyName(): string
    {
        return $this->parameters['auth_key_name'];
    }

    public function getPrivateKey(): string
    {
        return $this->parameters['private_key'];
    }
}

