<?php
require_once __DIR__ . '/../vendor/autoload.php';

$api = new \Spotify\Spotify();

//search test
$search = $api->Search->SearchAlbum('St. Anger');

echo "saving search results to file.\n";
file_put_contents('search-album.json', json_encode($search->albums->items));

$albumTracks = $api->Albums->GetAlbumTracks('4kwN2OnnrwY2ZBcm379Ahn');

echo "saving album track results to file.\n";
file_put_contents('album-tracks.json', json_encode($albumTracks));

echo "Done.\n";