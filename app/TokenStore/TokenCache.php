<?php
/**
 * Created by PhpStorm.
 * User: Thijs
 * Date: 2-1-2019
 * Time: 18:55
 */

class TokenCache
{
    public function storeTokens($access_token, $refresh_token, $expires)
    {

        $data = [
            'access_token'   => $access_token,
            'refresh_token' => $refresh_token,
            'token_expires' => $expires,
            'user_id' => 1
        ];

        Database::getInstance()->replace('oauth', $data);
    }

    public function clearTokens($userId)
    {
        Database::getInstance()->delete('oauth', ['user_id' => $userId]);
    }

    public function getAccessToken()
    {

        $userId = 1;

        $result = Database::getInstance()->fetchRow('SELECT * FROM oauth WHERE user_id = :user_id', ['user_id' => $userId]);
        if(empty($result)) {
            return '';
        }

        // Check if token is expired
        //Get current time + 5 minutes (to allow for time differences)
        $now = time() + 300;
        if ($result['token_expires'] <= $now) {
            // Token is expired (or very close to it)
            // so let's refresh

            // Initialize the OAuth client
            $oauthClient = new \League\OAuth2\Client\Provider\GenericProvider([
                'clientId' => env('OAUTH_APP_ID'),
                'clientSecret' => env('OAUTH_APP_PASSWORD'),
                'redirectUri' => env('OAUTH_REDIRECT_URI'),
                'urlAuthorize' => env('OAUTH_AUTHORITY') . env('OAUTH_AUTHORIZE_ENDPOINT'),
                'urlAccessToken' => env('OAUTH_AUTHORITY') . env('OAUTH_TOKEN_ENDPOINT'),
                'urlResourceOwnerDetails' => '',
                'scopes' => env('OAUTH_SCOPES')
            ]);

            try {
                $newToken = $oauthClient->getAccessToken('refresh_token', [
                    'refresh_token' => $result['refresh_token']
                ]);

                // Store the new values
                $this->storeTokens($newToken->getToken(), $newToken->getRefreshToken(),
                    $newToken->getExpires());

                return $newToken->getToken();
            } catch (League\OAuth2\Client\Provider\Exception\IdentityProviderException $e) {
                print_r($e->getMessage());
                return '';
            }
        } else {
            // Token is still valid, just return it
            return $result['access_token'];
        }
    }
}