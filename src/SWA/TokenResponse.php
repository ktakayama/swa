<?php

namespace SWA;

final class TokenResponse
{
    private $json;

    function __construct($json) {
        $this->json = $json;
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

