<?php
/**
 * Created by Rubikin Team.
 * ========================
 * Date: 8/13/14
 * Time: 4:53 PM
 * Author: Mr_Idiot
 * Question? Come to our website at http://rubikin.com
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Acme\OAuthServerBundle\Controller;

use FOS\RestBundle\View\View;
use JMS\Serializer\SerializationContext;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use OAuth2\OAuth2AuthenticateException;
use Doctrine\ORM\EntityManager;
use FOS\OAuthServerBundle\Model\TokenManager;
use Acme\OAuthServerBundle\Entity\AccessToken;
use OAuth2\OAuth2;

class APIController extends Controller
{
    /**
     * ROUTE By FOSRestBundle: GET /user/{userID}
     * Method name: getUserAction($userID)
     *      -> Method: get
     *      -> Route: user/{userID}
     *      -> Route name: get_user
     * Can only be access from Access Token
     *
     * @param $userID
     *
     * @return mixed
     * @throws \Symfony\Component\Security\Core\Exception\AccessDeniedException
     * @throws \Symfony\Component\HttpKernel\Exception\NotFoundHttpException
     */
    public function getUserAction($userID)
    {
        /**
         * Require access token
         * Else throw exception
         */
        if (! is_a(
            $this->container->get('security.context')->getToken(),
            'FOS\OAuthServerBundle\Security\Authentication\Token\OAuthToken'
        )
        ) {
            $exception = new OAuth2AuthenticateException(
                OAuth2::HTTP_UNAUTHORIZED,
                OAuth2::TOKEN_TYPE_BEARER,
                'access_denied',
                'OAuth2 authentication required'
            );

            return $exception->getHttpResponse();
        }


        /**
         * @var TokenManager $tokenManager
         */
        $tokenManager = $this->container->get('fos_oauth_server.access_token_manager.default');
        /**
         * Get the OAuth AccessToken
         *
         * @var AccessToken $accessToken
         */
        $accessToken = $tokenManager->findTokenByToken(
            $this->container->get('security.context')->getToken()->getToken()
        );


        /**
         * Check for user exist
         */
        if (! is_object($accessToken->getUser())) {
            throw $this->createNotFoundException();
        }
        /**
         * Check for permission for User information
         */
        if ($userID != $accessToken->getUser()->getID()) {
            throw new AccessDeniedException();
        }

        /**
         * Get User information
         *
         * @var EntityManager $entityManager
         */

        $user = $accessToken->getUser();


        /**
         * Symfony Role = OAuth AccessToken Scope
         */
        $context = SerializationContext::create();

        if ($this->container->get('security.context')->isGranted('ROLE_ID_ACCESS')) {
            $context->setGroups("ROLE_ID_ACCESS");
        } else if ($this->container->get('security.context')->isGranted('ROLE_EMAIL_ACCESS')) {
            $context->setGroups("ROLE_EMAIL_ACCESS");
        } else if ($this->container->get('security.context')->isGranted('ROLE_USERNAME_ACCESS')) {
            $context->setGroups("ROLE_USERNAME_ACCESS");
        } else if ($this->container->get('security.context')->isGranted('ROLE_DOB_ACCESS')) {
            $context->setGroups("ROLE_DOB_ACCESS");
        } else if ($this->container->get('security.context')->isGranted('ROLE_ROLES_ACCESS')) {
            $context->setGroups("ROLE_ROLES_ACCESS");
        } else if ($this->container->get('security.context')->isGranted('ROLE_ALL_ACCESS')) {
            $context->setGroups("ROLE_ALL_ACCESS");
        }

        $view = View::create()
            ->setStatusCode('200')
            ->setData($user)
            ->setSerializationContext($context);

        return $this->get('fos_rest.view_handler')->handle($view);
    }

    /**
     * Sample API Interface
     * Can be access from User Session
     *
     * @return Response
     */
    public function getFreeToAccessAction()
    {
        return new Response('Everyone who has logged in can access to this Api');
    }
}
