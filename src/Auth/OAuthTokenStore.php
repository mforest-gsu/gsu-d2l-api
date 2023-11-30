<?php

declare(strict_types=1);

namespace GSU\D2L\API\Auth;

use GSU\D2L\API\Auth\D2LAuthAPI;
use GSU\D2L\API\Auth\OAuthToken;
use GSU\D2L\API\APIConfig;

class OAuthTokenStore
{
    protected ?OAuthToken $oauthToken = null;


    /**
     * @param APIConfig $config
     * @param D2LAuthAPI $authAPI
     */
    public function __construct(
        protected APIConfig $config,
        protected D2LAuthAPI $authAPI
    ) {
    }


    /**
     * @return OAuthToken
     */
    public function getOAuthToken(): OAuthToken
    {
        $saveToken = false;

        if ($this->oauthToken === null) {
            if (file_exists($this->config->oauthTokenPath)) {
                $oauthTokenString = file_get_contents($this->config->oauthTokenPath);
                if (!is_string($oauthTokenString)) {
                    throw new \RuntimeException("Error reading file: " . $this->config->oauthTokenPath);
                }
                $oauthTokenValues = json_decode($oauthTokenString, true, 2, JSON_THROW_ON_ERROR);
                if (!is_array($oauthTokenValues)) {
                    throw new \RuntimeException("Invalid contents in file: " . $this->config->oauthTokenPath);
                }
                $this->oauthToken = OAuthToken::create($oauthTokenValues);
            } else {
                $this->oauthToken = $this->authAPI->createOAuthToken();
                $saveToken = true;
            }
        }

        if ($this->oauthToken->isExpired()) {
            $this->oauthToken = $this->authAPI->refreshOAuthToken($this->oauthToken->refresh_token);
            $saveToken = true;
        }

        if ($saveToken === true) {
            $bytes = file_put_contents(
                $this->config->oauthTokenPath,
                json_encode($this->oauthToken, JSON_THROW_ON_ERROR)
            );
            if ($bytes === false) {
                throw new \RuntimeException("Error writing to file: " .  $this->config->oauthTokenPath);
            }
        }

        return $this->oauthToken;
    }
}
