<?php

namespace SWA;

use \Exception;

final class Request
{
    private $jwt;

    public function __construct($jwt)
    {
        $this->jwt = $jwt;
    }

    public function getAuthorizationCode($code, $redirect_uri)
    {
        return $this->authTokenRequest([
            'code' => $code,
            'grant_type' => 'authorization_code',
            'redirect_uri' => $redirect_uri,
        ]);
    }

    public function getAccessToken($refresh_token)
    {
        return $this->authTokenRequest([
            'grant_type' => 'refresh_token',
            'refresh_token' => $refresh_token,
        ]);
    }

    private function authTokenRequest($params)
    {
        $api = 'https://appleid.apple.com/auth/token';

        $secret = $this->jwt->getClientSecret();
        $params['client_id']     = $secret->getClaim('sub');
        $params['client_secret'] = (string)$secret;

        $ch = curl_init();
        curl_setopt_array($ch, [
            CURLOPT_URL => $api,
            CURLOPT_POSTFIELDS => http_build_query($params),
            CURLOPT_RETURNTRANSFER => true
        ]);
        $body = curl_exec($ch);
        curl_close($ch);
        $response = json_decode($body);

        if (isset($response->{'error'})) {
            throw new Exception($response->{'error'});
        }

        return (new \SWA\TokenResponse($response));
    }
}
