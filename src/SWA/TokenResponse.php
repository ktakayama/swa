<?php

namespace SWA;

final class TokenResponse
{
    private $json;

    public function __construct($json)
    {
        $this->json = $json;
    }

    public function getAccessToken()
    {
        return $this->json->{'access_token'};
    }

    public function getRefreshToken()
    {
        return $this->json->{'refresh_token'};
    }

    public function getIdToken()
    {
        return new \SWA\IdToken($this->json->{'id_token'});
    }
}
