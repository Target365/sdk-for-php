<?php

declare(strict_types = 1);

namespace Target365\ApiSdk\Model;

use Target365\ApiSdk\ApiClientException;

abstract class AbstractModel
{

    abstract protected function attributes(): array;

    abstract public function getIdentifier();

    public function populate(array $data): void
    {
        foreach ($data as $key => $value) {

            if (! in_array($key, $this->attributes()) ) {
                continue;
            }

            $methodName = 'set' . ucfirst($key);
            $this->$methodName($value);
        }

    }

    /**
     * Get data which will be serialized to JSON
     */
    public function normalize(): array
    {
        $normalizedData = [];

        foreach ($this->attributes() as $attribute) {
            $getter = 'get' . ucfirst($attribute);
            $value = $this->$getter();

            if (is_object($value) ) {
                if (!method_exists($value, '__toString') ) {
                    throw new ApiClientException('The object dosnt implement __toString()');
                }

                $normalizedData[$attribute] = $value->__toString();
            } else {
                if ($value === null) {
                    continue;
                }
                $normalizedData[$attribute] = $value;
            }
        }

        return $normalizedData;
    }

}
