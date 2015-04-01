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

final class Tracks {

    /**
     * Get a Track
     * @param string $trackId
     * @param string $market
     * @return mixed
     * @throws \Exception
     * @throws \Httpful\Exception\ConnectionErrorException
     */
    public function GetTrack($trackId, $market='') {
        try {
            $qs = !empty($market) ?
                '?market=' . strtoupper($market) :
                '';

            $response = Request::get(Spotify::BASE_URI . sprintf('/v1/tracks/%s', $trackId) . $qs)->send();

            //see if any errors resulted.
            if (!is_null($response->body->error)) {
                throw new \Exception($response->body->error->message);
            }

            return $response->body;
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }

    public function GetTracks($trackIds, $market='') {
        try {
            $qs = !empty($market) ?
                '&market=' . strtoupper($market) :
                '';

            $response = Request::get(Spotify::BASE_URI . sprintf('/v1/tracks?ids=%s', implode(',', $trackIds)) . $qs)->send();

            return $response->body;
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }
}