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

final class Artists {

    const Single = 'single';
    const Album = 'album';
    const AppearsOn = 'appears_on';
    const Compilation = 'compilation';
    const All = 'single, album, appears_on, compilation';

    /**
     * Get an Artist.
     * @param string $artistId
     * @return mixed
     * @throws \Httpful\Exception\ConnectionErrorException
     */
    public function GetArtist($artistId) {
        try {
            $response = Request::get(Spotify::BASE_URI . sprintf('/v1/artists/%s', $artistId))->send();

            return $response->body;
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }

    /**
     * Get Several Artists
     * @param array $artistIds
     * @return mixed
     * @throws \Httpful\Exception\ConnectionErrorException
     */
    public function GetArtists($artistIds) {
        try {
            $response = Request::get(Spotify::BASE_URI . sprintf('/v1/artists?ids=%s', implode(',', $artistIds)))->send();

            return $response->body;
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }

    /**
     * Get an Artist's Albums
     * @param string $artistId
     * @param array $albumType
     * @param int $limit
     * @param int $offset
     * @param string $market
     * @return mixed
     * @throws \Httpful\Exception\ConnectionErrorException
     */
    public function GetArtistAlbums($artistId, $albumType, $limit=0, $offset=0, $market='') {
        $parameters = [];

        try {
            if ($limit > 0) {
                $parameters[] = ['limit' => $limit];
                $parameters[] = ['offset' => $offset];
            }

            if (!empty($market)) {
                $parameters[] = ['market' => strtoupper($market)];
            }

            if (is_array($albumType) && count($albumType) > 0) {
                $parameters[] = ['album_type' => implode(',', $albumType)];
            }

            $uri = count($parameters) == 0 ?
                Spotify::BASE_URI . sprintf('/v1/artists/%s/albums', $artistId) :
                Spotify::BASE_URI . sprintf('/v1/artists/%s/albums?', $artistId) . http_build_query($parameters);

            $response = Request::get($uri)->send();

            return $response->body;
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }

    /**
     * Get an Artist's Top Tracks
     * @param string $artistId
     * @param string $country
     * @return mixed
     * @throws \Httpful\Exception\ConnectionErrorException
     */
    public function GetTopTracks($artistId, $country) {
        try {
            $response = Request::get(Spotify::BASE_URI . sprintf('/v1/artists/%s/top-tracks?country=%s', $artistId, $country))->send();

            return $response->body;
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }

    /**
     * Get an Artist's Related Artists
     * @param string $artistId
     * @return mixed
     * @throws \Httpful\Exception\ConnectionErrorException
     */
    public function FindRelatedArtists($artistId) {
        try {
            $response = Request::get(Spotify::BASE_URI . sprintf('/v1/artists/%s/related-artists', $artistId))->send();

            return $response->body;
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }
}