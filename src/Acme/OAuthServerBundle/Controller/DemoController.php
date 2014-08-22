<?php
/**
 * Created by Rubikin Team.
 * ========================
 * Date: 8/19/14
 * Time: 10:27 AM
 * Author: Mr_Idiot
 * Question? Come to our website at http://rubikin.com
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Acme\OAuthServerBundle\Controller;

use Doctrine\Orm\EntityManager;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DemoController extends Controller
{
    /**
     * Listener to route \
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function indexAction()
    {
        /**
         * @var EntityManager $entityManager
         */
        $entityManager = $this->getDoctrine()->getManager();
        $repo = $entityManager->getRepository('OAuthServerBundle:Client');
        $clients = $repo->findAll();

        return $this->render(
            "OAuthServerBundle:Default:index.html.twig",
            array(
                'clients' => $clients,
            )
        );
    }
}
