<?php

declare(strict_types=1);

namespace GSU\D2L\API\Outcomes\Model;

use mjfklib\Container\ArrayValue;
use mjfklib\Container\ObjectFactory;

class OutcomeDetails
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
            id: ArrayValue::getString($values, 'id'),
            description: ArrayValue::getString($values, 'description'),
            children: array_values(array_map(
                fn ($v) => self::create($v),
                ArrayValue::getArrayNull($values, 'children') ?? []
            ))
        );
    }


    public ?string $parentId = null;


    /**
     * @param string $id
     * @param string $description
     * @param array<int,OutcomeDetails> $children
     */
    public function __construct(
        public string $id,
        public string $description,
        public array $children = []
    ) {
        foreach ($this->children as $child) {
            $child->parentId = $id;
        }
    }
}
