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

use Httpful\Request;

final class Albums {

    /**
     * Get an Album
     * @param string $albumId Spotify Album Id
     * @param string $market
     * @return mixed
     * @throws \Httpful\Exception\ConnectionErrorException
     */
    public function GetAlbum($albumId, $market='') {
        try {
            $qs = !empty($market) ?
                '?market=' . strtoupper($market) :
                '';

            $response = Request::get(Spotify::BASE_URI . sprintf('/v1/albums/%s', $albumId) . $qs)->send();

            return $response->body;
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }

    /**
     * Get Several Albums
     * @param array $albumIds Array of Spotify Album Ids
     * @param string $market
     * @return mixed
     * @throws \Httpful\Exception\ConnectionErrorException
     */
    public function GetAlbums($albumIds, $market='') {
        try {
          $qs = !empty($market) ?
              '&market=' . strtoupper($market) :
              '';

            $response = Request::get(Spotify::BASE_URI . sprintf('/v1/albums?ids=%s', implode(',', $albumIds)) . $qs)->send();

            return $response->body;
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }

    /**
     * Get an Album's Tracks
     * @param $albumId
     * @param int $limit
     * @param int $offset
     * @param string $market
     * @return mixed
     * @throws \Httpful\Exception\ConnectionErrorException
     */
    public function GetAlbumTracks($albumId, $limit=0, $offset=0, $market='') {
        $parameters = [];

        try {
            if ($limit > 0) {
                $parameters[] = ['limit' => $limit];
                $parameters[] = ['offset' => $offset];
            }

            if (!empty($market)) {
                $parameters[] = ['market' => strtoupper($market)];
            }

            $uri = count($parameters) == 0 ?
                Spotify::BASE_URI . sprintf('/v1/albums/%s/tracks', $albumId) :
                Spotify::BASE_URI . sprintf('/v1/albums/%s/tracks?', $albumId) . http_build_query($parameters);

            $response = Request::get($uri)->send();

            return $response->body;
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }
}