<?php

namespace SWA;

use Lcobucci\JWT\Configuration;
use Lcobucci\JWT\Signer\Key\InMemory;
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

        $config = Configuration::forSymmetricSigner(new Sha256(), InMemory::plainText($pem));
        return $config->signer()->verify($this->getSign(), $this->header . "." . $this->payload, $config->signingKey());
    }

    private function decode($str)
    {
        return base64_decode(strtr($str, '-_.', '+/='));
    }
}
