<?php
/**
 * The UserController file doc comment
 *
 * PHP version 7.2.10
 *
 * @category Class
 * @package  Controller
 * @author   Samir,saro0h <allabsamir666@gmail.com>
 * @license  Copyright 2019 General public license
 * @link     src/AppBundle/Controller/UserController
 */
namespace AppBundle\Controller;

use AppBundle\Entity\User;
use AppBundle\Form\UserType;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * This class is used to manage the tasks
 *
 * @category Class
 * @package  Controller
 * @author   Samir,saro0h <allabsamir777@gmail.com>
 * @license  Copyright 2019 General public license
 * @link     src/AppBundle/Controller/UserController
 */
class UserController extends Controller
{
    /**
     * This function displays the users list
     *
     * @Route("/users", name="user_list")
     * @return Response a template twig listing users
     */
    public function listUser()
    {
        return $this->render(
            'user/list.html.twig',
            ['users' => $this->getDoctrine()
            ->getRepository('AppBundle:User')->findAll()]
        );
    }
    /**
     * This function allows to create a user
     *
     * @Route("/users/create", name="user_create")
     *
     * @param Request $request
     * @return Response
     */
    public function createUser(Request $request)
    {
        $user = new User();
        $form = $this->createForm(UserType::class, $user);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $password = $this->get('security.password_encoder')->encodePassword($user, $user->getPassword());
            $user->setPassword($password);

            $em->persist($user);
            $em->flush();
            
            $this->addFlash('success', "L'utilisateur a bien été ajouté.");

            return $this->redirectToRoute('user_list');
        }

        return $this->render('user/create.html.twig', ['form' => $form->createView()]);
    }
    /**
     * This function allows to edit a user
     *
     * @Route("/users/{id}/edit", name="user_edit")
     *
     * @param User $user
     * @param Request $request
     * @return Response format html
     */
    public function editUser(User $user, Request $request)
    {
        $form = $this->createForm(UserType::class, $user);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $password = $this->get('security.password_encoder')->encodePassword($user, $user->getPassword());
            $user->setPassword($password);

            $this->getDoctrine()->getManager()->flush();

            $this->addFlash('success', "L'utilisateur a bien été modifié");

            return $this->redirectToRoute('user_list');
        }

        return $this->render('user/edit.html.twig', ['form' => $form->createView(), 'user' => $user]);
    }
}
