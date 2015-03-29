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

final class Search {

    /**
     * Search for an Artist
     * @param $query
     * @param int $limit
     * @param int $offset
     * @param string $market
     * @return \Httpful\associative|string
     * @throws \Httpful\Exception\ConnectionErrorException
     */
    public function SearchArtist($query, $limit=0, $offset=0, $market='') {
        $parameters = [
            "q" => $query,
            "type" => "artist"
        ];

        try {
            if ($limit > 0) {
                $parameters[] = ['limit' => $limit];
                $parameters[] = ['offset' => $offset];
            }

            if (!empty($market)) {
                $parameters[] = ['market' => strtoupper($market)];
            }

            $uri = Spotify::BASE_URI . '/v1/search?' . http_build_query($parameters);

            $response = Request::get($uri)->send();

            return $response->body;
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }

    /**
     * Search for an Album
     * @param $query
     * @param int $limit
     * @param int $offset
     * @param string $market
     * @return \Httpful\associative|string
     * @throws \Httpful\Exception\ConnectionErrorException
     */
    public function SearchAlbum($query, $limit=0, $offset=0, $market='') {
        $parameters = [
            "q" => $query,
            "type" => "album"
        ];

        try {
            if ($limit > 0) {
                $parameters[] = ['limit' => $limit];
                $parameters[] = ['offset' => $offset];
            }

            if (!empty($market)) {
                $parameters[] = ['market' => strtoupper($market)];
            }

            $uri = Spotify::BASE_URI . '/v1/search?' . http_build_query($parameters);

            $response = Request::get($uri)->send();

            return $response->body;
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }

    /**
     * Search for Song Track
     * @param $query
     * @param int $limit
     * @param int $offset
     * @param string $market
     * @return \Httpful\associative|string
     * @throws \Httpful\Exception\ConnectionErrorException
     */
    public function SearchTrack($query, $limit=0, $offset=0, $market='') {
        $parameters = [
            "q" => $query,
            "type" => "track"
        ];

        try {
            if ($limit > 0) {
                $parameters[] = ['limit' => $limit];
                $parameters[] = ['offset' => $offset];
            }

            if (!empty($market)) {
                $parameters[] = ['market' => strtoupper($market)];
            }

            $uri = Spotify::BASE_URI . '/v1/search?' . http_build_query($parameters);

            $response = Request::get($uri)->send();

            return $response->body;
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }

    /**
     * Search for Playlist
     * @param $query
     * @param int $limit
     * @param int $offset
     * @param string $market
     * @return \Httpful\associative|string
     * @throws \Httpful\Exception\ConnectionErrorException
     */
    public function SearchPlaylist($query, $limit=0, $offset=0, $market='') {
        $parameters = [
            "q" => $query,
            "type" => "playlist"
        ];

        try {
            if ($limit > 0) {
                $parameters[] = ['limit' => $limit];
                $parameters[] = ['offset' => $offset];
            }

            if (!empty($market)) {
                $parameters[] = ['market' => strtoupper($market)];
            }

            $uri = Spotify::BASE_URI . '/v1/search?' . http_build_query($parameters);

            $response = Request::get($uri)->send();

            return $response->body;
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }
}