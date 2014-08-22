<?php
/**
 * Created by Rubikin Team.
 * ========================
 * Date: 8/18/14
 * Time: 2:19 PM
 * Author: Mr_Idiot
 * Question? Come to our website at http://rubikin.com
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Acme\OAuthServerBundle\Controller;

use Doctrine\ORM\EntityManager;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class UserController extends Controller
{
    /**
     * Listener to route \user
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function userAction()
    {
        /**
         * @var EntityManager $entityManager
         */
        $entityManager = $this->getDoctrine()->getManager();
        $repo = $entityManager->getRepository('OAuthServerBundle:Client');
        $clients = $repo->findAll();

        return $this->render(
            "OAuthServerBundle:User:index.html.twig",
            array(
                'clients' => $clients,
            )
        );
    }

    /**
     *
     */
    public function logoutAction()
    {

    }
}
