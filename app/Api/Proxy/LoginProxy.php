<?php

namespace App\Api\Proxy;

use App\Api\Exceptions\InvalidCredentialsException;
use App\Api\Models\User;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Request;

class LoginProxy
{
    const REFRESH_TOKEN = 'refreshToken';

    private $apiConsumer;

    public function __construct()
    {
        $this->apiConsumer = new Client(['base_uri' => env('APP_URL')]);
    }

    /**
     * Attempt to create an access token using user credentials
     *
     * @param string $email
     * @param string $password
     * @return array
     */
    public function attemptLogin($email, $password)
    {
        $user = User::where('email', $email)->first();

        if (!is_null($user)) {
            return $this->proxy('password', [
                    'username' => $email,
                    'password' => $password,
            ]);
        }

        throw new InvalidCredentialsException();
    }

    /**
     * Attempt to refresh the access token used a refresh token that
     * has been saved in a cookie
     */
    public function attemptRefresh()
    {
        // We do not need usuername/password or anything because it is saved in the encrypted httpOnly cookie.
        $refreshToken = Request::cookie(self::REFRESH_TOKEN);
        return $this->proxy('refresh_token', [
            'refresh_token' => $refreshToken
        ]);
    }

    /**
     * Proxy a request to the OAuth server.
     *
     * @param string $grantType what type of grant type should be proxied
     * @param array $data the data to send to the server
     * @return array
     */
    public function proxy($grantType, array $data = [])
    {
        $data = array_merge($data, [
            'grant_type' => $grantType,
            'client_id' => env('CLIENT_ID'),
            'client_secret' => env('CLIENT_SECRET'),
        ]);
        $form_data = [
            'form_params' => $data
        ];

        $response = $this->apiConsumer->post('/oauth/token', $form_data);

        if (!$response->getStatusCode() === 200) {
            throw new InvalidCredentialsException();
        }

        $data = json_decode($response->getBody());

        // Create a refresh token cookie
        Cookie::queue(
            self::REFRESH_TOKEN,
            $data->refresh_token,
            1210000, // 14 days
            null,
            null,
            false,
            true // HttpOnly
        );
//        dd(Cookie::getQueuedCookies());
        return [
            'access_token' => $data->access_token,
            'expires_in' => $data->expires_in
        ];
    }

    /**
     * Logs out the user. We revoke access token and refresh token.
     * Also instruct the client to forget the refresh cookie.
     */
    public function logout()
    {
        $accessToken = Auth::user()->token();

        $refreshToken = DB::table('oauth_refresh_tokens')
            ->where('access_token_id', $accessToken->id)
            ->update([
                'revoked' => true
            ]);

        $accessToken->revoke();

        Cookie::queue(Cookie::forget(self::REFRESH_TOKEN));
    }
}