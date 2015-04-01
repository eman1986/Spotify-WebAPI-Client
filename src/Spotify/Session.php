<?php
/**
 * Spotify Web API Client
 *
 * A PHP 5.4 client for the Spotify Web API.
 *
 * Ed Lomonaco
 * https://github.com/eman1986/Spotify-WebAPI-Client
 * MIT License
 */

namespace Spotify;

use Httpful\Mime;
use Httpful\Request;

trait Session {

    private $_accessToken;
    private $_refreshToken;
    private $_expires;
    private $_clientId;
    private $_secret;
    private $_redirectUri;

    /**
     * @return mixed
     */
    public function getAccessToken() {
        return $this->_accessToken;
    }

    /**
     * @param string $accessToken
     */
    public function setAccessToken($accessToken) {
        $this->_accessToken = $accessToken;
    }

    /**
     * @return mixed
     */
    public function getRefreshToken() {
        return $this->_refreshToken;
    }

    /**
     * @param string $refreshToken
     */
    public function setRefreshToken($refreshToken) {
        $this->_refreshToken = $refreshToken;
    }

    /**
     * @return mixed
     */
    public function getExpires() {
        return $this->_expires;
    }

    /**
     * @param string $expires
     */
    public function setExpires($expires) {
        $this->_expires = $expires;
    }

    /**
     * @return mixed
     */
    public function getClientId()
    {
        return $this->_clientId;
    }

    /**
     * @param mixed $clientId
     */
    public function setClientId($clientId)
    {
        $this->_clientId = $clientId;
    }

    /**
     * @return mixed
     */
    public function getSecret()
    {
        return $this->_secret;
    }

    /**
     * @param mixed $secret
     */
    public function setSecret($secret)
    {
        $this->_secret = $secret;
    }

    /**
     * @return mixed
     */
    public function getRedirectUri()
    {
        return $this->_redirectUri;
    }

    /**
     * @param mixed $redirectUri
     */
    public function setRedirectUri($redirectUri)
    {
        $this->_redirectUri = $redirectUri;
    }

    /**
     * Get Authorization Token.
     * @param string $code Authorization code from User Request Interaction.
     * @throws \Exception
     * @throws \Httpful\Exception\ConnectionErrorException
     */
    public function RequestAuthorizationToken($code) {
        $data = [
            'client_id' => $this->getClientId(),
            'client_secret' => $this->getSecret(),
            'code'          => $code,
            'redirect_uri'  => $this->getRedirectUri(),
            'grant_type'    => "authorization_code"
        ];

        $response = Request::post(self::ACCOUNT_URI . '/api/token')
            ->body(http_build_query($data), Mime::FORM)
            ->expects(Mime::JSON)
            ->send();

        //see if any errors resulted.
        if (!is_null($response->body->error)) {
            if (is_null($response->body->error_description)) {
                throw new \Exception($response->body->error);
            } else {
                throw new \Exception($response->body->error_description);
            }
        }

        $this->setAccessToken($response->body->access_token);
        $this->setExpires($response->body->expires_in);
        $this->setRefreshToken($response->body->refresh_token);
    }

    /**
     * Refresh Authorization Token
     * @throws \Exception
     * @throws \Httpful\Exception\ConnectionErrorException
     */
    public function RequestRefreshToken() {
        $basicAuthEncode = base64_encode($this->getClientId() . ':' . $this->getSecret());

        $data = [
            'refresh_token ' => $this->getRefreshToken(),
            'grant_type'    => "refresh_token"
        ];

        $response = Request::post(self::ACCOUNT_URI . '/api/token')
            ->addHeader('Authorization', 'Basic ' . $basicAuthEncode)
            ->body(http_build_query($data), Mime::FORM)
            ->expects(Mime::JSON)
            ->send();

        //see if any errors resulted.
        if (!is_null($response->body->error)) {
            if (is_null($response->body->error_description)) {
                throw new \Exception($response->body->error);
            } else {
                throw new \Exception($response->body->error_description);
            }
        }

        $this->setAccessToken($response->body->access_token);
        $this->setExpires($response->body->expires_in);
    }

    /**
     * Client Credential Request.
     * @throws \Exception
     * @throws \Httpful\Exception\ConnectionErrorException
     */
    public function RequestClientCredentials() {
        $basicAuthEncode = base64_encode($this->getClientId() . ':' . $this->getSecret());

        $data = [
            'refresh_token ' => $this->getRefreshToken(),
            'grant_type'    => "client_credentials"
        ];

        $response = Request::post(self::ACCOUNT_URI . '/api/token')
            ->addHeader('Authorization', 'Basic ' . $basicAuthEncode)
            ->body(http_build_query($data), Mime::FORM)
            ->expects(Mime::JSON)
            ->send();

        if (!is_null($response->body->error)) {
            if (is_null($response->body->error_description)) {
                throw new \Exception($response->body->error);
            } else {
                throw new \Exception($response->body->error_description);
            }
        }

        $this->setAccessToken($response->body->access_token);
        $this->setExpires($response->body->expires_in);
    }
}