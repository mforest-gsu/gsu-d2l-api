<?php

declare(strict_types=1);

namespace GSU\D2L\API;

use mjfklib\Container\DefinitionSource;
use mjfklib\Container\Env;

class APIDefinitionSource extends DefinitionSource
{
    /**
     * @inheritdoc
     */
    protected function createDefinitions(Env $env): array
    {
        return [
            APIConfig::class => static::factory([APIConfig::class, 'create'], [
                'values' => $env
            ])
        ];
    }
}
