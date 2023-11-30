<?php

declare(strict_types=1);

namespace GSU\D2L\API\Core\Model;

use mjfklib\Container\ArrayValue;
use mjfklib\Container\ObjectFactory;

/**
 * @template T
 */
class PagedResultSet
{
    /**
     * @param mixed $values
     * @param (callable(mixed $v): T) $castItem
     * @return self<T>
     */
    public static function create(
        mixed $values,
        callable $castItem
    ): self {
        return ObjectFactory::createObject(
            $values,
            self::class,
            fn (array $values): self => self::construct($values, $castItem)
        );
    }


    /**
     * @param mixed[] $values
     * @param (callable(mixed $v): T) $castItem
     * @return self<T>
     */
    public static function construct(
        array $values,
        callable $castItem
    ): self {
        return new self(
            PagingInfo: PagingInfo::create(ArrayValue::getArray($values, 'PagingInfo')),
            Items: array_map(
                $castItem,
                ArrayValue::getArray($values, 'Items')
            )
        );
    }


    /**
     * @param PagingInfo $PagingInfo
     * @param T[] $Items
     */
    public function __construct(
        public PagingInfo $PagingInfo,
        public array $Items
    ) {
    }
}
