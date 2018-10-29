<?php

/*
 * This file is part of the FOSUserBundle package.
 *
 * (c) FriendsOfSymfony <http://friendsofsymfony.github.com/>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Security\Csrf\CsrfTokenManagerInterface;
use FOS\UserBundle\Controller\SecurityController as BaseController;
use Symfony\Component\Routing\RouterInterface;

/**
 * Controller managing security.
 *
 * @author Thibault Duplessis <thibault.duplessis@gmail.com>
 * @author Christophe Coevoet <stof@notk.org>
 */
class SecurityController extends BaseController
{

    private $tokenManager;

    public function __construct(CsrfTokenManagerInterface $tokenManager = null)
    {

    }

    /**
     * @param Request $request
     *
     * @return Response
     */
    public function loginAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $categ =$em->getRepository('AppBundle:Categorie')->findBy(array(
            'parent'=>null));
        $products=$em->getRepository('AppBundle:Product')->findBy(array(
            'isavailable'=>true));

        $pubs=$em->getRepository('AppBundle:Publicite')->findBy(array(
            'position'=>1));
        $pubs2=$em->getRepository('AppBundle:Publicite')->findBy(array(
            'position'=>2));
        $categ =$em->getRepository('AppBundle:Categorie')->findBy(array(
            'parent'=>null));

        // var_dump($categ);
        $quote =$em->getRepository('AppBundle:Quote')->findAll();
        $marque =$em->getRepository('AppBundle:Marque')->findAll();
        $ev =$em->getRepository('AppBundle:Event')->findAll();

        if($request->getMethod()=="POST" )
        {
            $inp= $em->getRepository('AppBundle:Product')->findprod($request->get("q"));

            return $this->render('MainBundle:ecom:recherche.html.twig', array(
                'inp'=>$inp,
                "categ"=>$categ,
                "prods"=>$products,
                "pubs"=>$pubs,
                "pubs2"=>$pubs2,
                "quote"=>$quote,
                "ev"=>$ev,
                "marque"=>$marque,
                "initcmp"=> $this->get('session')->get('cmp' ),
                "initpan"=> $this->get('session')->get('panier' ),
                // ...
            ));
        }

        /** @var $session Session */
        $session = $request->getSession();

        $authErrorKey = Security::AUTHENTICATION_ERROR;
        $lastUsernameKey = Security::LAST_USERNAME;

        // get the error if any (works with forward and redirect -- see below)
        if ($request->attributes->has($authErrorKey)) {
            $error = $request->attributes->get($authErrorKey);
        } elseif (null !== $session && $session->has($authErrorKey)) {
            $error = $session->get($authErrorKey);
            $session->remove($authErrorKey);
        } else {
            $error = null;
        }

        if (!$error instanceof AuthenticationException) {
            $error = null; // The value does not come from the security component.
        }

        // last username entered by the user
        $lastUsername = (null === $session) ? '' : $session->get($lastUsernameKey);

        $csrfToken = $this->tokenManager
            ? $this->tokenManager->getToken('authenticate')->getValue()
            : null;



        return $this->renderLogin(array(
            'last_username' => $lastUsername,
            'error' => $error,
            'csrf_token' => $csrfToken,
            "categ"=>$categ,
            "initcmp"=> $this->get('session')->get('cmp' ),
            "initpan"=> $this->get('session')->get('panier' ),

        ));
    }

    public function checkAction()
    {
        throw new \RuntimeException('You must configure the check path to be handled by the firewall using form_login in your security firewall configuration.');
    }

    public function logoutAction()
    {
        throw new \RuntimeException('You must activate the logout in your security firewall configuration.');
    }






    /**
     * Renders the login template with the given parameters. Overwrite this function in
     * an extended controller to provide additional data for the login template.
     *
     * @param array $data
     *
     * @return Response
     */
    protected function renderLogin(array $data)
    {

        return $this->render('@FOSUser/Security/login.html.twig', $data);
    }
}
