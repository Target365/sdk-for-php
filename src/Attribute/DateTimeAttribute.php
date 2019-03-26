<?php

declare(strict_types = 1);

namespace Target365\ApiSdk\Attribute;

use Target365\ApiSdk\Exception\ApiClientException;

class DateTimeAttribute extends \DateTime
{
    protected const DATE_TIME_FORMAT = \DateTime::ATOM; // This is IS08601 format which is used by the API

    /**
     * @param string $iso8601dateTime ISO8601 datetime string, possibly with fractional seconds
     *        the number of digits after the decimal point can vary but its even possible to have 7 or more
     *
     * example:
     * 2018-10-03T22:24:59.0678561+00:00
     * 2018-10-03T22:24:59+00:00
     * @throws ApiClientException
     * @throws \Exception
     */
    public function __construct(string $iso8601dateTime)
    {
        $iso8601dateTime = $this->normalizeIso8601($iso8601dateTime);

        parent::__construct($iso8601dateTime);
    }


    public function __toString(): string
    {
        return $this->format(self::DATE_TIME_FORMAT);
    }

    /**
     * Remove fractional seconds from ISO8601 string
     *
     * @param string $iso8601dateTime string with or without fractional seconds
     * @return string
     * @throws ApiClientException
     */
    protected function normalizeIso8601(string $iso8601dateTime): string
    {
        //String might include fractional seconds, discard fractional seconds.
        $pattern = '~(\\d{4}-\\d{2}-\\d{2}T\\d{2}:\\d{2}:\\d{2})\\.\\d{1,9}([-+]\\d{2}:\\d{2})~';
        $matchCount = preg_match($pattern, $iso8601dateTime, $matches);

        if ($matchCount === 1) {
            $iso8601dateTime = $matches[1] . $matches[2];
        }

        // check that string is now ISO8601 date string (without fractional seconds)
        // and force that it's timezone is UTC
        $tempDateTime = \DateTime::createFromFormat(self::DATE_TIME_FORMAT, $iso8601dateTime);

        if (!$tempDateTime) {
            throw new ApiClientException('The input format should be ' . self::DATE_TIME_FORMAT);
        }

        if ($tempDateTime->getTimezone()->getName() !== '+00:00') {
            throw new ApiClientException('the input datetime string should be in timezone +00:00');
        }

        return $iso8601dateTime;
    }
}
