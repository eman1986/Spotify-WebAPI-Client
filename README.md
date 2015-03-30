# Spotify-WebAPI-Client
A PHP 5.4 client for the Spotify Web API.

This client makes it easy for you to utilize the Spotify Web API and works to handle much of the background tasks
involved.

**This library is currently under heavy development, a stable release will be ready soon.**

## Installing

The recommended method will be composer.

## Setup Access Request URL.
Some tasks require user's consent, a helper has been created to aid with this.

```php
$api = new \Spotify\Spotify();

$authUrl = $api->BuildRequestUrl('clientId', 'redirectUrl', 'scope');
```

## Framework Integrations

I am planning on adding framework integration for the follow frameworks:

* Laravel 4 & 5
* Codeigniter 3
* FuelPHP

I may add more to the list later, requests can be made on the issue tracker.