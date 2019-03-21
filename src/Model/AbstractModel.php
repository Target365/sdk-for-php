<?php

declare(strict_types = 1);

namespace Target365\ApiSdk\Model;

use Target365\ApiSdk\Exception\ApiClientException;

abstract class AbstractModel
{
    abstract protected function attributes(): array;

    abstract public function getIdentifier(): ?string;

    public function populate(array $data): void
    {
        foreach ($data as $key => $value) {
            if (!in_array($key, $this->attributes()) || $value == null) {
                continue;
            }
            
            if ($key == "properties") {
                $properties = new Properties;
                foreach ($value as $innerKey => $innerValue) {
                    $properties->$innerKey = $innerValue;
                }
                
                $this->setProperties($properties);
            } else {
                $methodName = 'set' . ucfirst($key);
                $this->$methodName($value);
            }
        }
    }

    public function normalize(): array
    {
        $normalizedData = [];

        foreach ($this->attributes() as $attribute) {
            $getter = 'get' . ucfirst($attribute);
            $value = $this->$getter();

            if ($value === null) {
                continue;
            }
            
            if ($value instanceof Properties && $value !== null) {
                $array = array();
                
                foreach ($value as $key => $value) {
                    $array[$key] = $value;
                }
                
                $normalizedData[$attribute] = $array;
                continue;
            }
            
            if (is_object($value)) {
                if (!method_exists($value, '__toString')) {
                    throw new ApiClientException('Object does not implement __toString()');
                }

                $normalizedData[$attribute] = $value->__toString();
            } else {
                $normalizedData[$attribute] = $value;
            }
        }

        return $normalizedData;
    }
}
