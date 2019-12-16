<?php

namespace SWA;

final class Payload
{
    private $json;

    function __construct($payload) {
        $this->json = json_decode($payload);
    }

    function get($key) {
        return $this->json->{$key};
    }

    function getIss() {
        return $this->get('iss');
    }

    function getAud() {
        return $this->get('aud');
    }

    function getExp() {
        return $this->get('exp');
    }

    function getIat() {
        return $this->get('iat');
    }

    function getSub() {
        return $this->get('sub');
    }

    function getEmail() {
        return $this->get('email');
    }

    function getEmailVerified() {
        return $this->get('email_verified');
    }

    function getIsPrivate() {
        return $this->get('is_private_email');
    }

    function getAuthTime() {
        return $this->get('auth_time');
    }

}

