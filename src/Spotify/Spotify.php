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

final class Spotify {
    use Session;

    const BASE_URI = 'https://api.spotify.com';
    const ACCOUNT_URI = 'https://accounts.spotify.com';

    public $Search;
    public $Albums;
    public $Artists;
    public $Track;
    public $Playlists;
    public $Profile;
    public $Library;
    public $Browse;
    public $Follow;

    /**
     * @param string $clientId
     * @param string $secret
     * @param string $redirectUri
     */
    public function __construct($clientId='', $secret='', $redirectUri='') {
        $this->setClientId($clientId);
        $this->setSecret($secret);
        $this->setRedirectUri($redirectUri);

        $this->Albums = new Albums;
        $this->Artists = new Artists;
        $this->Search = new Search;
        $this->Playlists = new Playlists;
    }

    /**
     * Build the request URL for the user to authorize access.
     * @param array $scope List of Scopes
     * @param string $state A security token created by your application.
     * @param bool $showDialog Whether or not to force the user to approve the app again if they’ve already done so.
     * @return string
     */
    public function BuildRequestUrl($scope, $state='', $showDialog=false) {
        $parameters = [
            'client_id' => $this->getClientId(),
            'redirect_uri' => $this->getRedirectUri(),
            'response_type' => 'code',
            'scope' => implode(' ', $scope),
            'show_dialog' => $showDialog,
            'state' => $state,
        ];

        return self::ACCOUNT_URI . '/authorize/?' . http_build_query($parameters);
    }

    /**
     * Convert Spotify object IDs to Spotify URIs.
     * @param array $ids
     * @return array
     */
    public static function idToUri($ids)
    {
        $ids = (array) $ids;
        for ($i = 0; $i < count($ids); $i++) {
            if (strpos($ids[$i], 'spotify:track:') !== false) {
                continue;
            }
            $ids[$i] = 'spotify:track:' . $ids[$i];
        }

        return $ids;
    }
}