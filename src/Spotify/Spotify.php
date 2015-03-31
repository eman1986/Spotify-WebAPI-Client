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

final class Spotify {

    const BASE_URI = 'https://api.spotify.com';
    const ACCOUNT_URI = 'https://accounts.spotify.com';

    public $Search;
    public $Albums;
    public $Artists;
    public $Track;
    public $Playlist;
    public $Profile;
    public $Library;
    public $Browse;
    public $Follow;

    private $_accessToken;
    private $_refreshToken;
    private $_expires;

    public function __construct() {
        $this->Albums = new Albums;
        $this->Artists = new Artists;
        $this->Search = new Search;
    }

    /**
     * Get Access Token
     * @return mixed
     */
    public function getAccessToken() {
        return $this->_accessToken;
    }

    /**
     * Set Access Token
     * @param string $accessToken
     */
    public function setAccessToken($accessToken) {
        $this->_accessToken = $accessToken;
    }

    /**
     * Get Refresh Token
     * @return mixed
     */
    public function getRefreshToken() {
        return $this->_refreshToken;
    }

    /**
     * Set Refresh Token
     * @param string $refreshToken
     */
    public function setRefreshToken($refreshToken) {
        $this->_refreshToken = $refreshToken;
    }

    /**
     * Get Expiration
     * @return mixed
     */
    public function getExpires() {
        return $this->_expires;
    }

    /**
     * Set Expiration
     * @param string $expires
     */
    public function setExpires($expires) {
        $this->_expires = $expires;
    }

    /**
     * Build the request URL for the user to authorize access.
     * @param string $clientId Your Client ID provided by Spotify.
     * @param string $redirectUrl The URI to redirect to after the user grants/denies permission.
     * @param array $scope List of Scopes
     * @param string $state A security token created by your application.
     * @param bool $showDialog Whether or not to force the user to approve the app again if they’ve already done so.
     * @return string
     */
    public function BuildRequestUrl($clientId, $redirectUrl, $scope, $state='', $showDialog=false) {
        $parameters = [
            'client_id' => $clientId,
            'redirect_uri' => $redirectUrl,
            'response_type' => 'code',
            'scope' => implode(' ', $scope),
            'show_dialog' => $showDialog,
            'state' => $state,
        ];

        return self::ACCOUNT_URI . '/authorize/?' . http_build_query($parameters);
    }

    /**
     * Get Authorization Token.
     * @param string $clientId Client ID provided by Spotify.
     * @param string $secret Secret Token provided by Spotify.
     * @param string $redirectUrl This parameter is used for validation only of callback url.
     * @param string $code Authorization code from User Request Interaction.
     * @throws \Httpful\Exception\ConnectionErrorException
     */
    public function RequestAuthorizationToken($clientId, $secret, $redirectUrl, $code) {
        $data = [
            'client_id' => $clientId,
            'client_secret' => $secret,
            'code'          => $code,
            'redirect_uri'  => $redirectUrl,
            'grant_type'    => "authorization_code"
        ];

        $response = Request::post(self::ACCOUNT_URI . '/api/token')
            ->body(json_encode($data), Mime::JSON)
            ->send();

        $this->setAccessToken($response->access_token);
        $this->setExpires($response->expires_in);
        $this->setRefreshToken($response->refresh_token);
    }

    /**
     * Refresh Authorization Token
     * @param string $clientId Client ID provided by Spotify.
     * @param string $secret Secret Token provided by Spotify.
     * @throws \Httpful\Exception\ConnectionErrorException
     */
    public function RequestRefreshToken($clientId, $secret) {
        $basicAuthEncode = base64_encode($clientId . ':' . $secret);

        $data = [
            'refresh_token ' => $this->getRefreshToken(),
            'grant_type'    => "refresh_token"
        ];

        $response = Request::post(self::ACCOUNT_URI . '/api/token')
            ->addHeader('Authorization', 'Basic ' . $basicAuthEncode)
            ->body(json_encode($data), Mime::JSON)
            ->send();

        $this->setAccessToken($response->access_token);
        $this->setExpires($response->expires_in);
    }

    /**
     * @param string $clientId Client ID provided by Spotify.
     * @param string $secret Secret Token provided by Spotify.
     * @throws \Httpful\Exception\ConnectionErrorException
     */
    public function RequestClientCredentials($clientId, $secret) {
        $basicAuthEncode = base64_encode($clientId . ':' . $secret);

        $data = [
            'refresh_token ' => $this->getRefreshToken(),
            'grant_type'    => "client_credentials"
        ];

        $response = Request::post(self::ACCOUNT_URI . '/api/token')
            ->addHeader('Authorization', 'Basic ' . $basicAuthEncode)
            ->body(json_encode($data), Mime::JSON)
            ->send();

        $this->setAccessToken($response->access_token);
        $this->setExpires($response->expires_in);
    }
}