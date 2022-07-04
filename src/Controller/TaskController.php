<?php

namespace App\Controller;

use App\Entity\Task;
use App\Forms\TaskType;
use App\Repository\TaskRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Persistence\ManagerRegistry;

class TaskController extends AbstractController
{
    /**
     * @Route("/tasks", name="task_list")
     */
    public function listAction(ManagerRegistry $doctrine)
    {
        if (!$this->isGranted('IS_AUTHENTICATED_FULLY')) {
            return $this->redirectToRoute('homepage');
        }

        return $this->render('task/list.html.twig', ['tasks' => $doctrine->getRepository(Task::class)->findBy(
            ['user' => $this->getUser()]
        )]);
    }

    /**
     * @Route("/tasks/create", name="task_create")
     */
    public function createAction(Request $request, ManagerRegistry $doctrine)
    {

        if (!$this->isGranted('IS_AUTHENTICATED_FULLY')) {
            return $this->redirectToRoute('homepage');
        }

        $task = new Task();
        $form = $this->createForm(TaskType::class, $task);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $author = $this->getUser();

            $em = $doctrine->getManager();

            $task->setUser($author);
            $em->persist($task);
            $em->flush();

            $this->addFlash('success', 'La tâche a été bien été ajoutée.');

            return $this->redirectToRoute('task_list');
        }

        return $this->render('task/create.html.twig', ['form' => $form->createView()]);
    }

    /**
     * @Route("/tasks/{id}/edit", name="task_edit")
     */
    public function editAction(Task $task, Request $request, ManagerRegistry $doctrine)
    {

        if (!$this->isGranted('IS_AUTHENTICATED_FULLY')) {
            return $this->redirectToRoute('homepage');
        }

        if ($task->getUser()->getEmail() != $this->getUser()->getUserIdentifier() && $this->isGranted('ROLE_USER')){
            
            return $this->redirectToRoute('homepage');
        
        }elseif ($task->getUser()->getUsername() == 'anonymous' && $this->isGranted('ROLE_USER')){

            return $this->redirectToRoute('homepage');
        
        }else{

        $form = $this->createForm(TaskType::class, $task);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $doctrine->getManager()->flush();

            $this->addFlash('success', 'La tâche a bien été modifiée.');

            return $this->redirectToRoute('task_list');
        }

        return $this->render('task/edit.html.twig', [
            'form' => $form->createView(),
            'task' => $task,
        ]);

    }
    }

    /**
     * @Route("/tasks/{id}/toggle", name="task_toggle")
     */
    public function toggleTaskAction(Task $task, ManagerRegistry $doctrine)
    {

        if (!$this->isGranted('IS_AUTHENTICATED_FULLY')) {
            return $this->redirectToRoute('homepage');
        }

        if ($task->getUser()->getEmail() != $this->getUser()->getUserIdentifier() && $this->isGranted('ROLE_USER')){
            
            return $this->redirectToRoute('homepage');
        
        }elseif ($task->getUser()->getUsername() == 'anonymous' && $this->isGranted('ROLE_USER')){

            return $this->redirectToRoute('homepage');
        
        }else{

        $task->toggle(!$task->getIsDone());
        $doctrine->getManager()->flush();

        $this->addFlash('success', sprintf('La tâche %s a bien été marquée comme faite.', $task->getTitle()));

        return $this->redirectToRoute('task_list');

        }
    }

    /**
     * @Route("/tasks/{id}/delete", name="task_delete")
     */
    public function deleteTaskAction(Task $task, ManagerRegistry $doctrine)
    {

        if (!$this->isGranted('IS_AUTHENTICATED_FULLY')) {
            return $this->redirectToRoute('homepage');
        }

        if ($task->getUser()->getEmail() != $this->getUser()->getUserIdentifier() && $this->isGranted('ROLE_USER')){
            
            return $this->redirectToRoute('homepage');
        
        }elseif ($task->getUser()->getUsername() == 'anonymous' && $this->isGranted('ROLE_USER')){

            return $this->redirectToRoute('homepage');
        
        }else{

        $em = $doctrine->getManager();
        $em->remove($task);
        $em->flush();

        $this->addFlash('success', 'La tâche a bien été supprimée.');

        return $this->redirectToRoute('task_list');
        }

    }
}
