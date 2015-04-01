<?php
require_once __DIR__ . '/../vendor/autoload.php';

// ================
//      CONFIG
// ================
$clientId = '';
$secret = '';
$callbackUrl = '';


$api = new \Spotify\Spotify();

$scope = array(
    Spotify\Scopes::None
);

$authLink = $api->BuildRequestUrl($clientId, $callbackUrl, $scope);

echo "saving request auth link to file.\n";
file_put_contents('auth-link.json', $authLink);

$code = '';

$api->RequestAuthorizationToken($clientId, $secret, $callbackUrl, $code);

$results = array(
    "AccessToken" => $api->getAccessToken(),
    "ExpiresOn" => $api->getExpires(),
    "RefreshToken" => $api->getRefreshToken()
);

echo "saving Auth Tokens to file.\n";
file_put_contents('auth.json', json_encode($results));