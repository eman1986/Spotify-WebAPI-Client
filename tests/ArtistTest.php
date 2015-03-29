<?php
require_once __DIR__ . '/../vendor/autoload.php';

$api = new \Spotify\Spotify();

//search test
$search = $api->Search->SearchArtist('Metallica');

echo "saving search results to file.\n";
file_put_contents('search-artist.json', json_encode($search->artists->items));

$topTracks = $api->Artists->GetTopTracks('2ye2Wgw4gimLv2eAKyk1NB', 'US');

echo "saving top tracks results to file.\n";
file_put_contents('top-tracks.json', json_encode($topTracks));

$relatedArtists = $api->Artists->FindRelatedArtists('2ye2Wgw4gimLv2eAKyk1NB');

echo "saving related artist results to file.\n";
file_put_contents('related-artists.json', json_encode($relatedArtists));

echo "Done.\n";