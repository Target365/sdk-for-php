<?php

declare(strict_types = 1);

namespace Target365\ApiSdk\Tests;

use Ramsey\Uuid\Uuid;

class Fixtures
{
    static public function generateUuid4(): string
    {
        $uuid4 = Uuid::uuid4();

        return $uuid4->toString(); // i.e. 25769c6c-d34d-4bfe-ba98-e0ee856f3e7a
    }


    static public function getShortNumberId()
    {
        return 'NO-0000';
    }

    static public function getTransactionId()
    {
        return '79f35793-6d70-423c-a7f7-ae9fb1024f3b';
    }


    static private $fixedRandomTransactionId = null;
    static public function getFixedRandomTransactionId(): string
    {
        if (self::$fixedRandomTransactionId) {
            return self::$fixedRandomTransactionId;
        } else {
            self::$fixedRandomTransactionId = self::generateUuid4();

            return self::$fixedRandomTransactionId;
        }
    }

}