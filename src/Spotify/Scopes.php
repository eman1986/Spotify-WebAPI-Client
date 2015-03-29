<?php
/**
 * Spotify Web API Client
 *
 * A PHP 5.4 client for the Spotify Web API.
 *
 * Ed Lomonaco
 * https://github.com/eman1986/Spotify-WebAPI-Client
 * MIT License
 *
 * Read more about Scopes at the link below:
 * https://developer.spotify.com/web-api/using-scopes/
 */

namespace Spotify;

final class Scopes {

    /**
     * Access is permitted only to publicly available information.
     */
    const None = "";

    /**
     * Read access to user's private playlists.
     */
    const Playlist_Read_Private = "playlist-read-private";

    /**
     * Write access to a user's public playlists.
     */
    const Playlist_Modify_Public = "playlist-modify-public";

    /**
     * Write access to a user's private playlists.
     */
    const Playlist_Modify_Private = "playlist-modify-private";

    /**
     * Control playback of a Spotify track. (Premium Accounts Only)
     */
    const Streaming = "streaming";

    /**
     * Write/delete access to the list of artists and other users that the user follows.
     */
    const User_Follow_Modify = "user-follow-modify";

    /**
     * Read access to the list of artists and other users that the user follows.
     */
    const User_Follow_Read = "user-follow-read";

    /**
     * Read access to a user's "Your Music" library.
     */
    const User_Library_Read = "user-library-read";

    /**
     * Write/delete access to a user's "Your Music" library.
     */
    const User_Library_Modify = "user-library-modify";

    /**
     * Read access to user’s subscription details.
     */
    const User_Read_Private = "user-read-private";

    /**
     * 	Read access to the user's birthdate.
     */
    const User_Read_Birthdate = "user-read-birthdate";

    /**
     * Read access to user’s email address.
     */
    const User_Read_Email = "user-read-email";
}