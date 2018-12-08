<?php

namespace App\Controller;

use App\Entity\Task;
use App\Form\TaskType;
use App\Repository\TaskRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TaskController extends AbstractController
{
    /**
     * Lists all tasks
     * 
     * @Route("/", methods={"GET"}, name="task_index")
     */
    public function index(TaskRepository $tasks): Response
    {
        $allTasks = $tasks->findAll();

        return $this->render('task/index.html.twig', ['tasks' => $allTasks]);
    }

    /**
     * Creates a new Task entity.
     *
     * @Route("/new", methods={"GET", "POST"}, name="task_new")
     */
    public function new(Request $request): Response
    {
        $task = new Task();

        $form = $this->createForm(TaskType::class, $task);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            // entity manager
            $em = $this->getDoctrine()->getManager();
            $em->persist($task);
            $em->flush();

            $this->addFlash('success', 'task.created_successfully');

            return $this->redirectToRoute('task_index');
        }

        return $this->render('task/new.html.twig', [
            'task' => $task,
            'form' => $form->createView(),
        ]);
    }

    /**
     * Displays a form to edit an existing Task entity.
     *
     * @Route("/{id<\d+>}/edit",methods={"GET", "POST"}, name="task_edit")
     */
    public function edit(Request $request, Task $task): Response
    {
        $form = $this->createForm(TaskType::class, $task);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            $this->addFlash('success', 'task.updated_successfully');

            return $this->redirectToRoute('task_edit', ['id' => $task->getId()]);
        }

        return $this->render('task/edit.html.twig', [
            'task' => $task,
            'form' => $form->createView(),
        ]);
    }

    /**
     * Deletes a Task entity.
     *
     * @Route("/{id}/delete", methods={"GET", "POST"}, name="task_delete")
     */
    public function delete(Request $request, Task $task): Response
    {
        if (!$this->isCsrfTokenValid('delete', $request->request->get('token'))) {
            return $this->redirectToRoute('task_index');
        }

        $em = $this->getDoctrine()->getManager();
        $em->remove($task);
        $em->flush();

        $this->addFlash('success', 'task.deleted_successfully');

        return $this->redirectToRoute('task_index');
    }
}