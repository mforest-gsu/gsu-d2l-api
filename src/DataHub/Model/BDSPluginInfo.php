<?php

declare(strict_types=1);

namespace GSU\D2L\API\DataHub\Model;

use mjfklib\Container\ArrayValue;
use mjfklib\Container\ObjectFactory;

class BDSPluginInfo
{
    /**
     * @param mixed $values
     * @return self
     */
    public static function create(mixed $values): self
    {
        return ObjectFactory::createObject($values, self::class, fn (array $values): self => new self(
            PluginId: ArrayValue::getString($values, 'PluginId'),
            Name: ArrayValue::getString($values, 'Name'),
            Description: ArrayValue::getString($values, 'Description'),
            ExtractsLink: ArrayValue::getString($values, 'ExtractsLink'),
            Extracts: !is_null($values['Extracts'] ?? null)
                ? array_map(
                    fn (object|array $v): BDSExtractInfo => BDSExtractInfo::create($v),
                    array_filter(
                        ArrayValue::getArray($values, 'Extracts'),
                        fn (mixed $v): bool => is_object($v) || is_array($v)
                    )
                ) :
                []
        ));
    }


    /**
     * @param string $PluginId
     * @param string $Name
     * @param string $Description
     * @param string $ExtractsLink
     * @param BDSExtractInfo[] $Extracts
     */
    public function __construct(
        public readonly string $PluginId,
        public readonly string $Name,
        public readonly string $Description,
        public readonly string $ExtractsLink,
        public array $Extracts = []
    ) {
    }
}
