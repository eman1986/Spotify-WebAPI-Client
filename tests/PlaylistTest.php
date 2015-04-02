<?php
require_once __DIR__ . '/../vendor/autoload.php';

$api = new \Spotify\Spotify('CLIENT ID HERE', 'SECRET HERE', 'CALLBACK URI HERE');

$scope = array(
    Spotify\Scopes::None,
    Spotify\Scopes::Playlist_Read_Private,
    Spotify\Scopes::Playlist_Modify_Public,
    Spotify\Scopes::Playlist_Modify_Private
);

$api->RequestClientCredentials();

$playlists = $api->Playlists->GetUserPlaylist('USER ID');

echo "Saving User Playlist Results to file.\n";
file_put_contents('user-playlist.json', json_encode($results));

//@todo: setup more tests for Playlist Object.

echo "Done.\n";