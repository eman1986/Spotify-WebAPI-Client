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

    /**
     * Get a List of a User's Playlists
     * @param $userId
     * @param int $limit
     * @param int $offset
     * @return mixed
     * @throws \Exception
     * @throws \Httpful\Exception\ConnectionErrorException
     */
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

    /**
     * Get a Playlist
     * @param string $userId
     * @param string $playlistId
     * @param string string $fields
     * @return mixed
     * @throws \Exception
     * @throws \Httpful\Exception\ConnectionErrorException
     */
    public function GetPlaylist($userId, $playlistId, $fields='') {
        try {
            $uri = empty($fields) ?
                Spotify::BASE_URI . sprintf('/v1/users/%s/playlists/%s', $userId, $playlistId) :
                Spotify::BASE_URI . sprintf('/v1/users/%s/playlists/%s?fields=%s', $userId, $playlistId, $fields);

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

    /**
     * Get a Playlist's Tracks
     * @param string $userId
     * @param string $playlistId
     * @param string string $market
     * @param string string $fields
     * @param int $limit
     * @param int $offset
     * @return mixed
     * @throws \Exception
     * @throws \Httpful\Exception\ConnectionErrorException
     */
    public function GetPlaylistTracks($userId, $playlistId, $market='', $fields='', $limit=0, $offset=0) {
        $parameters = [];

        try {
            if ($limit > 0) {
                $parameters[] = ['limit' => $limit];
                $parameters[] = ['offset' => $offset];
            }

            if (!empty($market)) {
                $parameters[] = ['market' => strtoupper($market)];
            }

            if (!empty($fields)) {
                $parameters[] = ['fields' => strtoupper($fields)];
            }

            $uri = count($parameters) == 0 ?
                Spotify::BASE_URI . sprintf('/v1/users/%s/playlists/%s/tracks', $userId, $playlistId) :
                Spotify::BASE_URI . sprintf('/v1/users/%s/playlists/%s/tracks?', $userId, $playlistId) . http_build_query($parameters);

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

    /**
     * Create a Playlist
     * @param string $userId
     * @param string $playlistName
     * @param bool $isPublic
     * @return mixed
     * @throws \Exception
     * @throws \Httpful\Exception\ConnectionErrorException
     */
    public function CreatePlaylist($userId, $playlistName, $isPublic) {
        try {
            $data = [
                "name" => $playlistName,
                'public' => $isPublic
            ];

            $response = Request::post(Spotify::BASE_URI . sprintf('/v1/users/%s/playlists', $userId))
                ->addHeader('Authorization', 'Bearer ' . $this->getAccessToken())
                ->body(json_encode($data), Mime::JSON)
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

    /**
     * Change a Playlist's Details
     * @param string $userId
     * @param string $playlistId
     * @param string $playlistName
     * @param bool $isPublic
     * @return mixed|bool
     * @throws \Exception
     * @throws \Httpful\Exception\ConnectionErrorException
     */
    public function UpdatePlaylist($userId, $playlistId, $playlistName, $isPublic) {
        try {
            $data = [
                "name" => $playlistName,
                'public' => $isPublic
            ];

            $response = Request::put(Spotify::BASE_URI . sprintf('/v1/users/%s/playlists/%s', $userId, $playlistId))
                ->addHeader('Authorization', 'Bearer ' . $this->getAccessToken())
                ->body(json_encode($data), Mime::JSON)
                ->send();

            //see if any errors resulted.
            if (!is_null($response->body->error)) {
                throw new \Exception($response->body->error->message);
            }

            return true;
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }

    /**
     * Add Tracks to a Playlist
     * @param string $userId
     * @param string $playlistId
     * @param array $trackIds
     * @param null|int $position
     * @return mixed
     * @throws \Exception
     * @throws \Httpful\Exception\ConnectionErrorException
     */
    public function AddTrackToPlaylist($userId, $playlistId, $trackIds, $position=null) {
        $parameters = [];

        try {
            if (!is_array($trackIds)) {
                throw new \Exception("Track IDs parameter must be in an array format.");
            }

            if (!is_null($position)) {
                $parameters[] = ["position" => $position];
            }

            $uri = count($parameters) == 0 ?
                Spotify::BASE_URI . sprintf('/v1/users/%s/playlists/%s/tracks', $userId, $playlistId) :
                Spotify::BASE_URI . sprintf('/v1/users/%s/playlists/%s/tracks?', $userId, $playlistId) . http_build_query($parameters);

            $response = Request::post($uri)
                ->addHeader('Authorization', 'Bearer ' . $this->getAccessToken())
                ->body(json_encode(Spotify::idToUri($trackIds)), Mime::JSON)
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

    /**
     * Remove Tracks from a Playlist
     * @param string $userId
     * @param string $playlistId
     * @param array $trackIds
     * @return bool
     * @throws \Exception
     * @throws \Httpful\Exception\ConnectionErrorException
     */
    public function RemoveTracksFromPlaylist($userId, $playlistId, $trackIds) {
        $data = [];

        try {
            if (!is_array($trackIds)) {
                throw new \Exception("Track IDs parameter must be in an array format.");
            }

            foreach(Spotify::idToUri($trackIds) as $track) {
                $data[] = ['uri' => $track];
            }

            $response = Request::delete(Spotify::BASE_URI . sprintf('/v1/users/%s/playlists/%s/tracks', $userId, $playlistId))
                ->addHeader('Authorization', 'Bearer ' . $this->getAccessToken())
                ->body(json_encode($data), Mime::JSON)
                ->send();

            //see if any errors resulted.
            if (!is_null($response->body->error)) {
                throw new \Exception($response->body->error->message);
            }

            return true;
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }
}