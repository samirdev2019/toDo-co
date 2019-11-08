<?php
/**
 * The DefaultController file doc comment
 *
 * PHP version 7.2.10
 *
 * @category Class
 * @package  Controller
 * @author   Samir,saro0h <allabsamir666@gmail.com>
 * @license  Copyright 2019 General public license
 * @link     src/AppBundle/Controller/CommentController
 */
namespace AppBundle\Controller;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

/**
 * This class allows to show a home page of site
 *
 * @category Class
 * @package  Controller
 * @author   Samir,saro0h <allabsamir777@gmail.com>
 * @license  Copyright 2019 General public license
 * @link     src/AppBundle/Controller/CommentController
 */
class DefaultController extends Controller
{
    /**
     * This function allows to rendre the template of home page
     *
     * @Route("/", name="homepage")
     */
    public function index()
    {
        return $this->render('default/index.html.twig');
    }
}
