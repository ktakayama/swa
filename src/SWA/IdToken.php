<?php

namespace SWA;

use Lcobucci\JWT\Signer\Rsa\Sha256;
use CoderCat\JWKToPEM\JWKConverter;

final class IdToken
{
    private $header;
    private $payload;
    private $sign;

    public function __construct($id_token)
    {
        [ $header, $payload, $sign ] = explode('.', $id_token, 3);
        $this->header  = $header;
        $this->payload = $payload;
        $this->sign    = $sign;
    }

    public function getHeader()
    {
        return json_decode($this->decode($this->header));
    }

    public function getPayload()
    {
        return new \SWA\Payload($this->decode($this->payload));
    }

    public function getSign()
    {
        return $this->decode($this->sign);
    }

    public function verify()
    {
        $kid = $this->getHeader()->{'kid'};
        $pem = null;

        $keys = file_get_contents("https://appleid.apple.com/auth/keys");
        $json = json_decode($keys, true);

        foreach ($json['keys'] as $key) {
            if ($kid == $key['kid']) {
                $jwkConverter = new JWKConverter();
                $pem = $jwkConverter->toPEM($key);
                break;
            }
        }

        $payload = $this->header . "." . $this->payload;
        return (new \Lcobucci\JWT\Signature($this->getSign()))->verify(new Sha256(), $payload, $pem);
    }

    private function decode($str)
    {
        return base64_decode(strtr($str, '-_.', '+/='));
    }
}
