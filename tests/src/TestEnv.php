<?php

declare(strict_types=1);

namespace Test\GSU\D2L\API;

use GuzzleHttp\Psr7\HttpFactory;
use GSU\D2L\API\Auth\D2LAuthAPI;
use GSU\D2L\API\Auth\LoginTokenStore;
use GSU\D2L\API\Auth\OAuthTokenStore;
use GSU\D2L\API\APIConfig;
use GSU\D2L\API\Core\D2LAPIClient;
use Psr\Http\Client\ClientInterface;
use Psr\Http\Message\RequestFactoryInterface;
use Psr\Http\Message\ResponseFactoryInterface;

class TestEnv
{
    public APIConfig $config;
    public ClientInterface $httpClient;
    public RequestFactoryInterface $httpRequestFactory;
    public ResponseFactoryInterface $httpResponseFactory;
    public D2LAuthAPI $d2lAuthAPI;
    public LoginTokenStore $loginTokenStore;
    public OAuthTokenStore $oauthTokenStore;
    public D2LAPIClient $d2lAPIClient;


    public function __construct(
        APIConfig $config,
        ClientInterface $httpClient,
        ?RequestFactoryInterface $httpRequestFactory = null,
        ?RequestFactoryInterface $httpResponseFactory = null,
        ?D2LAuthAPI $d2lAuthAPI = null,
        ?LoginTokenStore $loginTokenStore = null,
        ?OAuthTokenStore $oauthTokenStore = null,
        ?D2LAPIClient $d2lAPIClient = null
    ) {
        $this->config = $config;
        $this->httpClient = $httpClient;

        $this->httpRequestFactory = $httpRequestFactory ?? new HttpFactory();
        $this->httpRequestFactory = $httpResponseFactory ?? new HttpFactory();
        $this->d2lAuthAPI = $d2lAuthAPI ?? new D2LAuthAPI(
            $this->config,
            $this->httpRequestFactory,
            $this->httpClient
        );
        $this->loginTokenStore = $loginTokenStore ?? new LoginTokenStore(
            $this->config,
            $this->d2lAuthAPI
        );
        $this->oauthTokenStore = $oauthTokenStore ?? new OAuthTokenStore(
            $this->config,
            $this->d2lAuthAPI
        );
        $this->d2lAPIClient = $d2lAPIClient ?? new D2LAPIClient(
            $this->config,
            $this->loginTokenStore,
            $this->oauthTokenStore,
            $this->httpRequestFactory,
            $this->httpClient,
        );
    }
}
