<?php
/**
 * The SecurityController file doc comment
 *
 * PHP version 7.2.10
 *
 * @category Class
 * @package  Controller
 * @author   Samir,saro0h <allabsamir666@gmail.com>
 * @license  Copyright 2019 General public license
 * @link     src/AppBundle/Controller/SecurityController
 */
namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * This class is used to manage authentication
 *
 * @category Class
 * @package  Controller
 * @author   Samir,saro0h <allabsamir777@gmail.com>
 * @license  Copyright 2019 General public license
 * @link     src/AppBundle/Controller/SecurityController
 */
class SecurityController extends Controller
{
    /**
     * This function display the login form and any login errors that may have occurred
     *  but the security system itself takes care of checking the submitted username and password
     *  and authenticating the user.
     *
     * @Route("/login", name="login")
     */
    public function loginAction(Request $request)
    {
        $authenticationUtils = $this->get('security.authentication_utils');

        $error = $authenticationUtils->getLastAuthenticationError();
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('security/login.html.twig', array(
            'last_username' => $lastUsername,
            'error'         => $error,
        ));
    }

    /**
     * @Route("/login_check", name="login_check")
     */
    public function loginCheck()
    {
        // This code is never executed.
    }

    /**
     * @Route("/logout", name="logout")
     */
    public function logoutCheck()
    {
        // This code is never executed.
    }
}
