<?php

namespace Mchljams\Chicagotransit\Entities;

abstract class Entity
{
    /**
     * BaseObject constructor.
     *
     * @param array $values
     *   Array of values keyed by object property names.
     */
    public function __construct(\stdClass $values)
    {
        $ro = new \ReflectionObject($this);

        foreach ($ro->getProperties() as $property) {
            // check if the property exsits on the input object
            if(!property_exists($values, $property->getName())) {
                // if the property doesnt exist, skip the rest of the loop
                continue;
            }

            $setter = 'set' . ucfirst($property->getName());

            if ($ro->hasMethod($setter)) {

                $value = $values->{$property->getName()};

                $rm = new \ReflectionMethod($this, $setter);

                try {
                    $rm->invoke($this, $value);
                } catch (\TypeError $error) {
                    // Auto-retry, pass the value as variable-length arguments.
                    // Ignore empty variable list.
                    if (is_array($value)) {
                        // Clear the value of the property.
                        if (empty($value)) {
                            $rm->invoke($this);
                        } else {
                            $rm->invoke($this, ...$value);
                        }
                    } else {
                        throw $error;
                    }
                }
            }
        }
    }

    public static function make(\stdClass $values)
    {
        return new self($values);
    }
}