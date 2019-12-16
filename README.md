Sign in with Apple.

```php
$code = ...
$redirect_uri = ...

$key = <<<EOT
-----BEGIN PRIVATE KEY-----
....
-----END PRIVATE KEY-----
EOT;

$token = (new \SWA\TokenBuilder())
        ->setPrivateKey($key)
        ->setKid(YOUR_KEY_ID)
        ->setIss(YOUR_TEAM_ID)
        ->setIat(time())
        ->setExp(time()+3600)
        ->setSub(YOUR_CLIENT_ID);

$authorization = (new \SWA\Reuest($token))->getAuthorizationCode($code, $redirect_uri);
$refresh_token = $authorization->getRefreshToken();
$email = $authorization->getIdToken()->getPayload()->getEmail();

$response = (new \SWA\Reuest($token))->getAccessToken($refresh_token);
$access_token = $response->getAccessToken();

echo $email . "\n";
echo $access_token . "\n";
```
