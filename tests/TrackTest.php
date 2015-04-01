<?php
require_once __DIR__ . '/../vendor/autoload.php';

$api = new \Spotify\Spotify();

//search test
$search = $api->Search->SearchTrack('Enter Sandman');

echo "saving search results to file.\n";
file_put_contents('search-track.json', json_encode($search->tracks->items));

//get track test.
$trackInfo = $api->Tracks->GetTrack('1hKdDCpiI9mqz1jVHRKG0E');

echo "saving track info to file.\n";
file_put_contents('track-info.json', json_encode($trackInfo));