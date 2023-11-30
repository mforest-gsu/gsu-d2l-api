<?php

declare(strict_types=1);

namespace GSU\D2L\API\Users\Model;

use mjfklib\Container\ArrayValue;
use mjfklib\Container\ObjectFactory;

class UserActivationData
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
            IsActive: ArrayValue::getBool($values, 'IsActive')
        );
    }


    /**
     * @param bool $IsActive
     */
    public function __construct(public bool $IsActive)
    {
    }
}
