<?php

declare(strict_types=1);

namespace Target365\ApiSdk\Model;

abstract class UserValidity
{
		public const UNREGISTERED = "Unregistered";
		public const PARTIAL = "Partial";
		public const FULL = "Full";
		public const BARRED = "Barred";
}
