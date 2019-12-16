<?php

namespace SWA;

final class IdToken
{
    private $header;
    private $payload;
    private $sign;

    function __construct($id_token) {
        [ $header, $payload, $sign ] = explode('.', $id_token, 3);
        $this->header  = base64_decode($header);
        $this->payload = base64_decode($payload);
        $this->sign    = base64_decode($sign);
    }

    function getHeader() {
        return $this->header;
    }

    function getPayload() {
        return new \SWA\Payload($this->payload);
    }

    function getSign() {
        return $this->sign;
    }

}


