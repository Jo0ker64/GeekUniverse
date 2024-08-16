<?php

namespace App\Controller\Admin;

use App\Entity\Book;
use App\Entity\Comment;
use App\Form\CommentType;
use App\Repository\CommentRepository;
use Doctrine\ORM\EntityManagerInterface;
use Pagerfanta\Doctrine\ORM\QueryAdapter;
use Pagerfanta\Pagerfanta;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[Route('/admin/comment')]

class CommentController extends AbstractController
{
    #[Route('', name: 'app_admin_comment_index', methods: ['GET'])]
    public function index(Request $request, CommentRepository $repository): Response
    {
        $comments = Pagerfanta::createForCurrentPageWithMaxPerPage(
            new QueryAdapter($repository->createQueryBuilder('c')),
            $request->query->get('page', 1),
            20
        );

        return $this->render('admin/comment/index.html.twig', [
            'comments' => $comments,
        ]);
    }

    #[IsGranted('ROLE_ADMIN')]
    #[Route('/{id}/edit', name: 'app_admin_comment_edit', requirements: ['id' => '\d+'], methods: ['GET', 'POST'])]
    public function edit(Comment $comment, Request $request, EntityManagerInterface $manager): Response
    {
        $form = $this->createForm(CommentType::class, $comment);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $manager->flush();

            return $this->redirectToRoute('app_admin_comment_index');
        }

        return $this->render('admin/comment/edit.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[IsGranted('ROLE_ADMIN')]
    #[Route('/{id}', name: 'app_admin_comment_delete', methods: ['DELETE'])]
    public function delete(Comment $comment, EntityManagerInterface $manager): Response
    {
        $manager->remove($comment);
        $manager->flush();

        return $this->redirectToRoute('app_admin_comment_index');
    }
}