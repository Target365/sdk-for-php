<?php

declare(strict_types = 1);

namespace Target365\ApiSdk\Exception;

class ResourceMethodNotAvailableException extends ApiClientException
{
    public function __construct()
    {
        parent::__construct('This method is not available for this resource');
    }
}
