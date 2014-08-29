<?php
/**
 * Created by Rubikin Team.
 * ========================
 * Date: 8/29/14
 * Time: 2:40 PM
 * Author: Mr_Idiot
 * Question? Come to our website at http://rubikin.com
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Acme\OAuthServerBundle\Requester;


use GuzzleHttp\Client;
use Symfony\Bundle\FrameworkBundle\Routing\Router;

class APIRequester
{
    /**
     * API Host URL
     * @var string $host
     */
    protected $host;

    /**
     * @var Router $router
     */
    protected $router;

    public function __construct(Router $router, $host)
    {
        $this->host = $host;
        $this->router = $router;
    }

    /**
     * Request for User information from API Interface
     *
     * @param string $userId
     * @param string $accessToken
     *
     * @return \GuzzleHttp\Stream\StreamInterface|null
     */
    public function requestUser($userId, $accessToken)
    {
        $uri = $this->host . $this->buildRequestUserURI($userId, $accessToken);
        $http = new Client();
        $res = $http->get($uri);

        return $res->getBody(true);
    }

    /**
     * Return URI for API request
     *
     * @param string $userId
     * @param string $accessToken
     *
     * @return string
     */
    protected function buildRequestUserURI($userId, $accessToken)
    {
        return $this->router->generate(
            'get_user',
            array(
                'userID' => $userId,
                'access_token' => $accessToken,
            )
        );
    }
}
