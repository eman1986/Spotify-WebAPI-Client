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

final class Playlists {
    use Session;

    public function GetUserPlaylist($userId, $limit=0, $offset=0) {
        $parameters = [];

        try {
            if ($limit > 0) {
                $parameters[] = ['limit' => $limit];
                $parameters[] = ['offset' => $offset];
            }

            $uri = count($parameters) == 0 ?
                Spotify::BASE_URI . sprintf('/v1/users/%s/playlists', $userId) :
                Spotify::BASE_URI . sprintf('/v1/users/%s/playlists?', $userId) . http_build_query($parameters);

            $response = Request::get($uri)
                ->addHeader('Authorization', 'Bearer ' . $this->getAccessToken())
                ->mime(Mime::JSON)
                ->send();

            //see if any errors resulted.
            if (!is_null($response->body->error)) {
                throw new \Exception($response->body->error->message);
            }

            return $response->body;
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }

}