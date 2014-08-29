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

            /**
             * Redirect user to OAuth server for user Auth code
             * This URI can be sent to user as a notification
             */

            return $this->container->get('oauth_requester')->redirectAuthCode(
                $client->getPublicId(),
                $client->getSecret(),
                $client->getRedirectUris()[0],
                $permission
            );
        }

        $json = null;
        $code = $request->get('code');
        /**
         * User comeback from OAuth server by Client's Redirect-uri with Auth code
         */
        if ($code != null) {
            $token = $this->container->get('oauth_requester')->requestTokenFromAuthCode(
                $client->getPublicId(),
                $client->getSecret(),
                $client->getRedirectUris()[0],
                $code
            );

            $currUserID = $this->getUser()->getId();

            $json = $this->container->get('api_requester')->requestUser(
                $currUserID,
                $token
            );
        }

        return $this->render(
            "OAuthServerBundle:Client:index.html.twig",
            array(
                'client' => $client,
                'json' => $json
            )
        );
    }
}
