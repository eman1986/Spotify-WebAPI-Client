<?php
require_once __DIR__ . '/../vendor/autoload.php';

$api = new \Spotify\Spotify('CLIENT ID HERE', 'SECRET HERE', 'CALLBACK URI HERE');

$scope = array(
    Spotify\Scopes::None
);

$authLink = $api->BuildRequestUrl($scope);

echo "saving request auth link to file.\n";
file_put_contents('auth-link.json', $authLink);

$code = '';

$api->RequestAuthorizationToken($code);

$results = array(
    "AccessToken" => $api->getAccessToken(),
    "ExpiresOn" => $api->getExpires(),
    "RefreshToken" => $api->getRefreshToken()
);

echo "saving Auth Tokens to file.\n";
file_put_contents('auth.json', json_encode($results));