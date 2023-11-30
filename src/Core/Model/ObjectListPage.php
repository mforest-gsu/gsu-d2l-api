<?php

declare(strict_types=1);

namespace GSU\D2L\API\Core\Model;

use mjfklib\Container\ArrayValue;
use mjfklib\Container\ObjectFactory;

/**
 * @template T
 */
class ObjectListPage
{
    /**
     * @param mixed $values
     * @param (callable(mixed $v): T) $castObject
     * @return self<T>
     */
    public static function create(
        mixed $values,
        callable $castObject
    ): self {
        return ObjectFactory::createObject(
            $values,
            self::class,
            fn (array $values): self => self::construct($values, $castObject)
        );
    }


    /**
     * @param mixed[] $values
     * @param (callable(mixed $v): T) $castObject
     * @return self<T>
     */
    public static function construct(
        array $values,
        callable $castObject
    ): self {
        return new self(
            Next: ArrayValue::getStringNull($values, 'PagingInfo'),
            Objects: array_map(
                $castObject,
                ArrayValue::getArray($values, 'Objects')
            )
        );
    }


    /**
     * @param string|null $Next
     * @param T[] $Objects
     */
    public function __construct(
        public ?string $Next,
        public array $Objects
    ) {
    }
}
