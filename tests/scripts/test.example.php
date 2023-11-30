<?php

declare(strict_types=1);

use GuzzleHttp\Client;
use GSU\D2L\API\APIConfig;
use GSU\D2L\API\Users\UsersAPI;
use Test\GSU\D2L\API\TestEnv;

include __DIR__ . '/../../vendor/autoload.php';

$env = new TestEnv(
    APIConfig::create(include(__DIR__ . '/config.test.php')),
    new Client()
);

$apiClient = new UsersAPI(
    $env->config,
    $env->loginTokenStore,
    $env->oauthTokenStore,
    $env->httpRequestFactory,
    $env->httpClient
);

$whoAmI = $apiClient->whoami();

echo json_encode($whoAmI, JSON_PRETTY_PRINT) . "\n";
