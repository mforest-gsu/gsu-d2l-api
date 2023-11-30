<?php

declare(strict_types=1);

namespace GSU\D2L\API\OrgUnits\Model;

use mjfklib\Container\ArrayValue;
use mjfklib\Container\ObjectFactory;

class OrgUnitTypeInfo
{
    /**
     * @param mixed $values
     * @return self
     */
    public static function create(mixed $values): self
    {
        return ObjectFactory::createObject($values, self::class, [self::class, 'construct']);
    }


    /**
     * @param mixed[] $values
     * @return self
     */
    public static function construct(array $values): self
    {
        return new self(
            Id: ArrayValue::getString($values, 'Id'),
            Code: ArrayValue::getString($values, 'Code'),
            Name: ArrayValue::getString($values, 'Name')
        );
    }


    /**
     * @param string $Id
     * @param string $Code
     * @param string $Name
     */
    public function __construct(
        public string $Id,
        public string $Code,
        public string $Name
    ) {
    }
}
