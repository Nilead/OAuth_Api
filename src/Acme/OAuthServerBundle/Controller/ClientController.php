<?php
/**
 * Created by Rubikin Team.
 * ========================
 * Date: 8/18/14
 * Time: 10:03 AM
 * Author: Mr_Idiot
 * Question? Come to our website at http://rubikin.com
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Acme\OAuthServerBundle\Controller;

use GuzzleHttp\Client;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Orm\EntityManager;
use Acme\OAuthServerBundle\Entity\Client as EntityClient;


class ClientController extends Controller
{
    /**
     * Listener to route \client\{clientID}
     *
     *  +--------+                               +---------------+
     *  |        |--(A)- Authorization Request ->|   Resource    |
     *  |        |    via buildAuthenCodeURI()   |     Owner     |
     *  |        |                               |               |
     *  |        |<-(B)-- Authorization Grant ---|               |
     *  |        |   via $client->redirectUris   +---------------+
     *  |        |
     *  |        |
     *  |        |                               +---------------+
     *  |        |--(C)-- Authorization Grant -->| Authorization |
     *  | Client |      via buildTokenURI()      |     Server    |
     *  |        |                               |               |
     *  |        |<-(D)----- Access Token -------|               |
     *  |        |    via $request->get('code')  +---------------+
     *  |        |
     *  |        |
     *  |        |                               +---------------+
     *  |        |--(E)----- Access Token ------>|    Resource   |
     *  |        |             via API           |     Server    |
     *  |        |                               |               |
     *  |        |<-(F)--- Protected Resource ---|               |
     *  +--------+                               +---------------+
     *
     * @param Request $request
     * @param int     $clientID
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function clientAction(Request $request, $clientID)
    {
        /**
         * @var EntityManager $entityManager
         */
        $entityManager = $this->getDoctrine()->getManager();
        $repo = $entityManager->getRepository('OAuthServerBundle:Client');

        /**
         * Get client by id for display information page
         *
         * @var EntityClient $client
         */
        $client = $repo->findOneBy(
            array(
                'id' => $clientID,
            )
        );

        /**
         * Receive permission from input form
         */
        if ($request->isMethod('POST')) {
            $permission = $request->request->get('choice_access');
            $uri = $this->buildAuthenCodeURI($client, $permission);

            /**
             * Redirect user to OAuth server for user Auth code
             * This URI can be sent to user as a notification
             */

            return $this->redirect($uri);
        }

        $json = null;
        $code = $request->get('code');
        /**
         * User comeback from OAuth server by Client's Redirect-uri with Auth code
         */
        if ($code != null) {
            $uri = $this->buildTokenURI($client, $code);
            $token = $this->getToken($request->getHost() . $uri);

            $currUserID = $this->container->get('security.context')->getToken()->getUser()->getId();

            $apiURI = $this->buildAPIURI($currUserID, $token);
            $json = $this->getJSONInfo($request->getHost() . $apiURI);
        }

        return $this->render(
            "OAuthServerBundle:Client:index.html.twig",
            array(
                'client' => $client,
                'json' => $json
            )
        );
    }

    /**
     * Generate URL for redirect user to OAuth server
     *
     * @param EntityClient $client
     * @param string       $permission
     *
     * @return string
     */
    private function buildAuthenCodeURI(EntityClient $client, $permission)
    {
        return $this->generateUrl(
            'fos_oauth_server_authorize',
            array(
                'client_id' => $client->getPublicId(),
                'redirect_uri' => $client->getRedirectUris()[0],
                'client_secret' => $client->getSecret(),
                'response_type' => 'code',
                'scope' => $permission,
            )
        );
    }

    /**
     * Generate URL for retrieve token from OAuth server
     *
     * @param EntityClient $client
     * @param string       $code
     *
     * @return string
     */
    private function buildTokenURI(EntityClient $client, $code)
    {
        return $this->generateUrl(
            'fos_oauth_server_token',
            array(
                'client_id' => $client->getPublicId(),
                'redirect_uri' => $client->getRedirectUris()[0],
                'client_secret' => $client->getSecret(),
                'grant_type' => 'authorization_code',
                'code' => $code,
            )
        );
    }

    /**
     * Generate URL for retrieve information from API endpoint
     *
     * @param int    $userId
     * @param string $token
     *
     * @return string
     */
    private function buildAPIURI($userId, $token)
    {
        return $this->generateUrl(
            'get_user',
            array(
                'userID' => $userId,
                'access_token' => $token,
            )
        );
    }

    /**
     * Get Token from OAuth server by presenting Auth Code
     *
     * @param string $uri
     *
     * @return string
     */
    private function getToken($uri)
    {
        $http = new Client();
        $res = $http->get($uri);
        $token = json_decode($res->getBody())->{'access_token'};

        return $token;
    }

    /**
     * Get JSON string from API Endpoint
     *
     * @param $uri
     *
     * @return \GuzzleHttp\Stream\StreamInterface|null
     */
    private function getJSONInfo($uri)
    {
        $http = new Client();
        $res = $http->get($uri);

        return $res->getBody(true);
    }
}
