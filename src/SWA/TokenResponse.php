<?php

namespace SWA;

final class TokenResponse
{
    private $json;

    function __construct($response) {
        $this->json = json_decode($response);
    }

    function getAccessToken() {
        return $this->json->{'access_token'};
    }

    function getRefreshToken() {
        return $this->json->{'refresh_token'};
    }

    function getIdToken() {
        return new \SWA\IdToken($this->json->{'id_token'});
    }
}

