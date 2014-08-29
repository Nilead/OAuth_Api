<?php
/**
 * Created by Rubikin Team.
 * ========================
 * Date: 8/29/14
 * Time: 11:57 AM
 * Author: Mr_Idiot
 * Question? Come to our website at http://rubikin.com
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Acme\OAuthServerBundle\Requester;


use GuzzleHttp\Client;
use Symfony\Bundle\FrameworkBundle\Routing\Router;
use Symfony\Component\HttpFoundation\RedirectResponse;

class OAuthRequester
{

    /**
     * OAuther Authenticate Endpoint Host URL
     * @var string $host
     */
    protected $host;

    /**
     * @var Router $router
     */
    protected $router;

    public function __construct(Router $router, $host)
    {
        $this->router = $router;
        $this->host = $host;
    }

    /**
     * Redirect respond for getting Auth Code
     *
     * @param string $client_id
     * @param string $client_secret
     * @param string $redirect_uri
     * @param string $scope
     *
     * @return RedirectResponse
     */
    public function redirectAuthCode($client_id, $client_secret, $redirect_uri, $scope)
    {
        $uri = $this->router->generate(
            'fos_oauth_server_authorize',
            array(
                'client_id' => $client_id,
                'client_secret' => $client_secret,
                'redirect_uri' => $redirect_uri,
                'response_type' => 'code',
                'scope' => $scope
            )
        );

        return new RedirectResponse($uri);
    }

    /**
     * Request for Access Token from Auth Code
     *
     * @param string $client_id
     * @param string $client_secret
     * @param string $redirect_uri
     * @param string $authCode
     *
     * @return string
     */
    public function requestTokenFromAuthCode($client_id, $client_secret, $redirect_uri, $authCode)
    {
        $uri = $this->host . $this->buildRequestTokenURI($client_id, $client_secret, $redirect_uri, $authCode);
        $http = new Client();
        $res = $http->get($uri);

        $token = json_decode($res->getBody())->{'access_token'};

        return $token;
    }

    /**
     * Request for Access Token from Client Credentials
     *
     * @param string $client_id
     * @param string $client_secret
     * @param string $redirect_uri
     *
     * @return string
     */
    public function requestTokenFromClientCredentials($client_id, $client_secret, $redirect_uri)
    {
        $uri = $this->host . $this->buildRequestTokenFromClientCredentialsURI(
                $client_id,
                $client_secret,
                $redirect_uri
            );
        $http = new Client();
        $res = $http->get($uri);

        $token = json_decode($res->getBody())->{'access_token'};

        return $token;
    }

    /**
     * Return URI for request Access Token from Auth Code
     *
     * @param string $client_id
     * @param string $client_secret
     * @param string $redirect_uri
     * @param string $authCode
     *
     * @return string
     */
    protected function buildRequestTokenURI($client_id, $client_secret, $redirect_uri, $authCode)
    {
        return $this->router->generate(
            'fos_oauth_server_token',
            array(
                'client_id' => $client_id,
                'client_secret' => $client_secret,
                'redirect_uri' => $redirect_uri,
                'grant_type' => 'authorization_code',
                'code' => $authCode,
            )
        );
    }

    /**
     * Return URI for request Access Token from Client Credentials
     *
     * @param string $client_id
     * @param string $client_secret
     * @param string $redirect_uri
     *
     * @return string
     */
    protected function buildRequestTokenFromClientCredentialsURI($client_id, $client_secret, $redirect_uri)
    {
        return $this->router->generate(
            'fos_oauth_server_token',
            array(
                'client_id' => $client_id,
                'client_secret' => $client_secret,
                'redirect_uri' => $redirect_uri,
                'grant_type' => 'client_credentials',
            )
        );
    }
}
