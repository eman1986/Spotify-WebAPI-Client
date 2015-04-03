<?php
require_once __DIR__ . '/../vendor/autoload.php';

$api = new \Spotify\Spotify('CLIENT ID HERE', 'SECRET HERE', 'CALLBACK URI HERE');

$scope = array(
    Spotify\Scopes::None,
    Spotify\Scopes::Playlist_Read_Private,
    Spotify\Scopes::Playlist_Modify_Public,
    Spotify\Scopes::Playlist_Modify_Private
);

$authLink = $api->BuildRequestUrl($scope);

echo "saving request auth link to file.\n";
file_put_contents('auth-link.json', $authLink);

$api->RequestClientCredentials();

$playlists = $api->Playlists->GetUserPlaylist('USER ID');

echo "Saving User Playlist Results to file.\n";
file_put_contents('user-playlist.json', json_encode($playlists));

$playlistData = $api->Playlists->GetPlaylist('USER ID', 'PLAYLIST ID');

echo "Saving Playlist Result to file.\n";
file_put_contents('user-playlist.json', json_encode($playlistData));

$playlistTracks = $api->Playlists->GetPlaylistTracks('USER ID', 'PLAYLIST ID');

echo "Saving Playlist Track Result to file.\n";
file_put_contents('user-playlist-tracks.json', json_encode($playlistTracks));

$createPlaylist = $api->Playlists->CreatePlaylist('USER ID', 'PLAYLIST NAME', false);

echo "Saving Create Playlist Response to file.\n";
file_put_contents('user-create-playlist.json', json_encode($createPlaylist));

$updatePlaylist = $api->Playlists->UpdatePlaylist('USER ID', 'PLAYLIST ID', 'PLAYLIST NAME', false);

echo "Saving Update Playlist Response to file.\n";
file_put_contents('user-update-playlist.json', json_encode($updatePlaylist));

$tracks = array();

$addTrack = $api->Playlists->AddTrackToPlaylist('USER ID', 'PLAYLIST ID', $tracks);

echo "Saving Add Track to Playlist Response to file.\n";
file_put_contents('user-add-playlist-track.json', json_encode($addTrack));

$addTrack = $api->Playlists->RemoveTracksFromPlaylist('USER ID', 'PLAYLIST ID', $tracks);

echo "Saving Remove Track to Playlist Response to file.\n";
file_put_contents('user-remove-playlist-track.json', json_encode($addTrack));

echo "Done.\n";