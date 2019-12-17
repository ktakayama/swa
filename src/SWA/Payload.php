<?php

namespace SWA;

final class Payload
{
    private $json;

    public function __construct($payload)
    {
        $this->json = json_decode($payload);
    }

    public function get($key)
    {
        return $this->json->{$key};
    }

    public function getIss()
    {
        return $this->get('iss');
    }

    public function getAud()
    {
        return $this->get('aud');
    }

    public function getExp()
    {
        return $this->get('exp');
    }

    public function getIat()
    {
        return $this->get('iat');
    }

    public function getSub()
    {
        return $this->get('sub');
    }

    public function getEmail()
    {
        return $this->get('email');
    }

    public function getEmailVerified()
    {
        return $this->get('email_verified');
    }

    public function getIsPrivate()
    {
        return $this->get('is_private_email');
    }

    public function getAuthTime()
    {
        return $this->get('auth_time');
    }
}
