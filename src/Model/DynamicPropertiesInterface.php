<?php

declare(strict_types=1);

namespace Target365\ApiSdk\Model;

interface DynamicPropertiesInterface
{
    public function getProperties(): ?Properties;
    public function setProperties(?Properties $properties);
}
