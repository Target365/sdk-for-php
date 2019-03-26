<?php

declare(strict_types=1);

namespace Target365\ApiSdk\Model;

abstract class StatusCodes
{
    public const QUEUED   = 'Queued';
    public const SENT     = 'Sent';
    public const FAILED   = 'Failed';
    public const OK       = 'Ok';
    public const REVERSED = 'Reversed';
}
