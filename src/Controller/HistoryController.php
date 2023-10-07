<?php

namespace App\Controller;

use App\Entity\History;
use App\Form\HistoryType;
use App\Repository\HistoryRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[Route('/history')]
class HistoryController extends AbstractController
{
    #[Route('/', name: 'app_history_index', methods: ['GET'])]
    #[IsGranted("ROLE_ADMIN", "ROLE_USER")]
    public function index(HistoryRepository $historyRepository): Response
    {
        return $this->render('history/index.html.twig', [
            'histories' => $historyRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_history_new', methods: ['GET', 'POST'])]
    #[IsGranted("ROLE_ADMIN")]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $history = new History();
        $form = $this->createForm(HistoryType::class, $history);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($history);
            $entityManager->flush();

            return $this->redirectToRoute('app_history_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('history/new.html.twig', [
            'history' => $history,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_history_show', methods: ['GET'])]
    #[IsGranted("ROLE_ADMIN", "ROLE_USER")]
    public function show(History $history): Response
    {
        return $this->render('history/show.html.twig', [
            'history' => $history,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_history_edit', methods: ['GET', 'POST'])]
    #[IsGranted("ROLE_ADMIN")]
    public function edit(Request $request, History $history, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(HistoryType::class, $history);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_history_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('history/edit.html.twig', [
            'history' => $history,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_history_delete', methods: ['POST'])]
    #[IsGranted("ROLE_ADMIN")]
    public function delete(Request $request, History $history, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$history->getId(), $request->request->get('_token'))) {
            $entityManager->remove($history);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_history_index', [], Response::HTTP_SEE_OTHER);
    }
}
