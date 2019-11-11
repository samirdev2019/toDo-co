<?php
/**
 * The TaskController file doc comment
 *
 * PHP version 7.2.10
 *
 * @category Class
 * @package  Controller
 * @author   Samir,saro0h <allabsamir666@gmail.com>
 * @license  Copyright 2019 General public license
 * @link     src/AppBundle/Controller/TaskController
 */
namespace AppBundle\Controller;

use AppBundle\Entity\Task;
use AppBundle\Form\TaskType;
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
 * @link     src/AppBundle/Controller/TaskController
 */
class TaskController extends Controller
{
    /**
     * This function returns the tasks list
     *
     * @Route("/tasks", name="task_list")
     */
    public function listTask()
    {
        return $this->render(
            'task/list.html.twig',
            ['tasks' => $this->getDoctrine()
            ->getRepository('AppBundle:Task')->findAll()]
        );
    }

    /**
     * This function allows to create a task
     *
     * @Route("/tasks/create", name="task_create")
     *
     * @param Request $request
     * @return void
     */
    public function createTask(Request $request)
    {
        
        $task = new Task();
        $form = $this->createForm(TaskType::class, $task);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManger = $this->getDoctrine()->getManager();
            /* 1. correction d'annomalie: automatiquement, à la sauvegarde de la tâche,
             l’utilisateur actuellement authentifié soit rattaché à la tâche nouvellement créée. */
            $task->setUser($this->getUser());
            $entityManger->persist($task);
            $entityManger->flush();
            $this->addFlash('success', 'La tâche a été bien été ajoutée.');

            return $this->redirectToRoute('task_list');
        }

        return $this->render('task/create.html.twig', ['form' => $form->createView()]);
    }

    /**
     * This function allow to edit a task
     *
     * @Route("/tasks/{id}/edit", name="task_edit")
     *
     * @param Task $task
     * @param Request $request
     * @return void
     */
    public function editTask(Task $task, Request $request)
    {
        $form = $this->createForm(TaskType::class, $task);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            $this->addFlash('success', 'La tâche a bien été modifiée.');

            return $this->redirectToRoute('task_list');
        }

        return $this->render('task/edit.html.twig', [
            'form' => $form->createView(),
            'task' => $task,
        ]);
    }
    /**
     * This function allows to toggle a task
     *
     * @Route("/tasks/{id}/toggle", name="task_toggle")
     *
     * @param Task $task
     * @return void
     */
    public function toggleTask(Task $task)
    {
        $task->toggle(!$task->isDone());
        $this->getDoctrine()->getManager()->flush();

        $this->addFlash('success', sprintf('La tâche %s a bien été marquée comme faite.', $task->getTitle()));

        return $this->redirectToRoute('task_list');
    }
    /**
     * This Function allows to delete a task
     *
     * @Route("/tasks/{id}/delete", name="task_delete")
     *
     * @param Task $task
     * @return void
     */
    public function deleteTask(Task $task)
    {
        $this->denyAccessUnlessGranted('delete', $task);
        $entityManger = $this->getDoctrine()->getManager();
        $entityManger->remove($task);
        $entityManger->flush();

        $this->addFlash('success', 'La tâche a bien été supprimée.');

        return $this->redirectToRoute('task_list');
    }
}
