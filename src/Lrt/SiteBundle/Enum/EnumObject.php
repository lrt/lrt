<?php

namespace Lrt\SiteBundle\Enum;

class EnumObject
{
    /**
     * Get enum constant data (array)
     * @return Array  array of Contract type
     */
    public function getData()
    {
        $reflect = new \ReflectionClass($this);
        $constants = $reflect->getConstants();

        return $constants;
    }

}
