<?php

namespace SWA;

final class IdToken
{
    private $header;
    private $payload;
    private $sign;

    public function __construct($id_token)
    {
        [ $header, $payload, $sign ] = explode('.', $id_token, 3);
        $this->header  = base64_decode($header);
        $this->payload = base64_decode($payload);
        $this->sign    = base64_decode($sign);
    }

    public function getHeader()
    {
        return $this->header;
    }

    public function getPayload()
    {
        return new \SWA\Payload($this->payload);
    }

    public function getSign()
    {
        return $this->sign;
    }
}
