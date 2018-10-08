<?php

declare(strict_types = 1);

namespace Target365\ApiSdk\Tests\Unit\Model;

use Target365\ApiSdk\Exception\ApiClientException;
use Target365\ApiSdk\Attribute\DateTimeAttribute;
use Target365\ApiSdk\Tests\AbstractTestCase;

class DateTimeAttributeTest extends AbstractTestCase
{
    public function testConstructorValid()
    {
        $originalTimezone = date_default_timezone_get();

        date_default_timezone_set('Australia/Sydney');

        $dateTimeAttribute = new DateTimeAttribute('2017-11-17T14:30:00+00:00');

        $this->assertEquals('17-11-2017 14:30:00', $dateTimeAttribute->format('d-m-Y H:i:s'));
        $this->assertEquals('2017-11-17T14:30:00+00:00', $dateTimeAttribute->__toString());

        // Ensure date is still output as expected even after changing time zone
        date_default_timezone_set('UTC');
        $this->assertEquals('2017-11-17T14:30:00+00:00', $dateTimeAttribute->__toString());

        date_default_timezone_set($originalTimezone); //Restore original timezone
    }

    public function testConstructorValidFractional()
    {
        $originalTimezone = date_default_timezone_get();

        $dateTimeAttribute = new DateTimeAttribute('2018-10-03T22:24:59.0678561+00:00');
        $this->assertEquals('03-10-2018 22:24:59', $dateTimeAttribute->format('d-m-Y H:i:s'));
    }

    public function testConstructorInvalidDate()
    {
        $this->expectException(ApiClientException::class);

        $dateTimeAttribute = new DateTimeAttribute('invalid date string');
    }

    public function testConstructorInvalidTimezone()
    {
        $this->expectException(ApiClientException::class);

        $dateTimeAttribute = new DateTimeAttribute('2017-11-17T14:30:00+02:00');
    }

}